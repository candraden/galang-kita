<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan form registrasi.
     * Tanpa tautan undangan -> mendaftar sebagai Penggalang Dana.
     * Dengan ?undangan=TOKEN -> mendaftar sebagai Anggota grup tersebut.
     */
    public function create(Request $request): View
    {
        $invitation = null;
        $invitationError = null;

        if ($token = $request->query('undangan')) {
            $found = Invitation::with('group.owner')->where('token', $token)->first();

            if ($found && $found->isUsable()) {
                $invitation = $found;
            } else {
                $invitationError = $found?->unusableReason() ?? 'Tautan undangan tidak valid.';
            }
        }

        return view('auth.register', [
            'invitation'      => $invitation,
            'invitationError' => $invitationError,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge(['email' => strtolower(trim((string) $request->email))]);

        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
            'invitation' => ['nullable', 'string', 'max:64'],
        ]);

        $invitation = null;

        if ($request->filled('invitation')) {
            $invitation = Invitation::with('group')->where('token', $request->invitation)->first();

            if (! $invitation || ! $invitation->isUsable()) {
                throw ValidationException::withMessages([
                    'invitation' => $invitation?->unusableReason() ?? 'Tautan undangan tidak valid.',
                ]);
            }
        }

        $user = DB::transaction(function () use ($request, $invitation) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Peran ditentukan server, bukan input form
            $roleName = $invitation ? 'member' : 'fundraiser';
            $user->roles()->attach(Role::where('name', $roleName)->value('id'));

            if ($invitation) {
                $invitation->redeem($user);
            }

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        if ($invitation) {
            return redirect()
                ->route('member.dashboard')
                ->with('status', 'Selamat datang! Kamu bergabung ke grup '.$invitation->group->name.'.');
        }

        return redirect()->route('fundraiser.dashboard');
    }
}
