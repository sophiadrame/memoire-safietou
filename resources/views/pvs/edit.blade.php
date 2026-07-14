@extends('layouts.app')
@section('title', 'Modifier le procès-verbal')

@section('content')
<div class="max-w-xl space-y-5">
    <a href="{{ route('pvs.index') }}" class="btn-secondary text-xs inline-flex">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>

    <form action="{{ route('pvs.update', $pv) }}" method="POST" class="card p-6 space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="label">Soutenance <span class="text-red-500">*</span></label>
            <select name="soutenance_id" required class="input-field">
                @foreach($soutenances as $s)
                <option value="{{ $s->id }}" {{ old('soutenance_id', $pv->soutenance_id) == $s->id ? 'selected' : '' }}>
                    {{ $s->etudiant_prenom }} {{ $s->etudiant_nom }} — {{ \Carbon\Carbon::parse($s->date_soutenance)->format('d/m/Y') }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="label">Note /20 <span class="text-red-500">*</span></label>
                <input type="number" name="note" value="{{ old('note', $pv->note) }}" required
                       step="0.5" min="0" max="20" class="input-field">
            </div>
            <div>
                <label class="label">Mention <span class="text-red-500">*</span></label>
                <select name="mention" required class="input-field">
                    @foreach(['Passable','Assez Bien','Bien','Très Bien'] as $m)
                    <option value="{{ $m }}" {{ old('mention', $pv->mention) === $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="label">Décision <span class="text-red-500">*</span></label>
            <select name="decision" required class="input-field">
                @foreach(['Admis','Ajourné','Admis avec réserves'] as $d)
                <option value="{{ $d }}" {{ old('decision', $pv->decision) === $d ? 'selected' : '' }}>{{ $d }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="label">Appréciation</label>
            <textarea name="appreciation" rows="4" class="input-field resize-none">{{ old('appreciation', $pv->appreciation) }}</textarea>
        </div>

        <div>
            <label class="label">Date du PV <span class="text-red-500">*</span></label>
            <input type="date" name="date_pv" value="{{ old('date_pv', $pv->date_pv) }}" required class="input-field">
        </div>

        <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
            <a href="{{ route('pvs.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection