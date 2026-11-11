@php
    $group = $group ?? null;
    $input = 'w-full rounded-input border-[1.5px] border-line bg-white px-4 text-sm focus:border-primary focus:outline-none focus:ring-0';
@endphp

<div class="space-y-5">
    <x-form-field label="Nama grup" name="name" :required="true">
        <input id="name" name="name" type="text" maxlength="100" required
               value="{{ old('name', $group?->name) }}" placeholder="Contoh: Kas Warga RT 05"
               class="{{ $input }} h-[50px]">
    </x-form-field>

    <x-form-field label="Kategori" name="category">
        <select id="category" name="category" class="{{ $input }} h-[50px]">
            <option value="">Pilih kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c }}" @selected(old('category', $group?->category) === $c)>{{ $c }}</option>
            @endforeach
        </select>
    </x-form-field>

    <x-form-field label="Deskripsi" name="description" hint="Maksimal 1000 karakter.">
        <textarea id="description" name="description" rows="4" maxlength="1000"
                  placeholder="Ceritakan tujuan grup ini"
                  class="{{ $input }} py-3">{{ old('description', $group?->description) }}</textarea>
    </x-form-field>

    <x-form-field label="Logo grup" name="logo" hint="JPG, PNG, atau WEBP. Maksimal 2 MB.">
        @if ($group?->logo_path)
            <div class="mb-3 flex items-center gap-3">
                <x-group-avatar :group="$group" size="size-14" />
                <label class="flex items-center gap-2 text-sm text-ink-muted">
                    <input type="checkbox" name="remove_logo" value="1" class="rounded border-line text-primary focus:ring-primary">
                    Hapus logo saat ini
                </label>
            </div>
        @endif
        <input id="logo" name="logo" type="file" accept="image/png,image/jpeg,image/webp"
               class="block w-full text-sm text-ink-muted file:mr-4 file:rounded-full file:border-0 file:bg-primary-tint file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-primary-dark hover:file:bg-primary-tint/70">
    </x-form-field>

    @if ($group)
        <x-form-field label="Status grup" name="status" :required="true">
            <select id="status" name="status" class="{{ $input }} h-[50px]">
                <option value="active" @selected(old('status', $group->status) === 'active')>Aktif</option>
                <option value="inactive" @selected(old('status', $group->status) === 'inactive')>Nonaktif</option>
            </select>
        </x-form-field>
    @endif
</div>
