@extends('layouts.app')
@section('title', 'Modifier le membre du jury')

@section('content')
<div class="max-w-xl space-y-5">
    <a href="{{ route('juries.index') }}" class="btn-secondary text-xs inline-flex">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>

    <form action="{{ route('juries.update', $jury) }}" method="POST" class="card p-6 space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="label">Soutenance concernée <span class="text-red-500">*</span></label>
            <select name="soutenance_id" required class="input-field">
                @foreach($soutenances as $s)
                <option value="{{ $s->id }}" {{ old('soutenance_id', $jury->soutenance_id) == $s->id ? 'selected' : '' }}>
                    {{ $s->etudiant_prenom }} {{ $s->etudiant_nom }} — {{ \Carbon\Carbon::parse($s->date_soutenance)->format('d/m/Y') }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="label">Enseignant inscrit (optionnel)</label>
            <select name="user_id" class="input-field">
                <option value="">Sélectionner...</option>
                @foreach($enseignants as $e)
                <option value="{{ $e->id }}" {{ old('user_id', $jury->user_id) == $e->id ? 'selected' : '' }}>
                    {{ $e->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="label">Prénom <span class="text-red-500">*</span></label>
                <input type="text" name="prenom" value="{{ old('prenom', $jury->prenom) }}" required class="input-field">
            </div>
            <div>
                <label class="label">Nom <span class="text-red-500">*</span></label>
                <input type="text" name="nom" value="{{ old('nom', $jury->nom) }}" required class="input-field">
            </div>
        </div>

        <div>
            <label class="label">Rôle <span class="text-red-500">*</span></label>
            <select name="role" required class="input-field">
                @foreach(['président','rapporteur','examinateur'] as $r)
                <option value="{{ $r }}" {{ old('role', $jury->role) === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="label">Grade</label>
            <input type="text" name="grade" value="{{ old('grade', $jury->grade) }}" class="input-field">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="label">Email</label>
                <input type="email" name="email" value="{{ old('email', $jury->email) }}" class="input-field">
            </div>
            <div>
                <label class="label">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone', $jury->telephone) }}" class="input-field">
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
            <a href="{{ route('juries.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection