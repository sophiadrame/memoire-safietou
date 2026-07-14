@extends('layouts.app')
@section('title', 'Nouveau procès-verbal')

@section('content')
<div style="max-width:700px;">

    <a href="{{ route('pvs.index') }}"
       style="display:inline-flex; align-items:center; gap:8px; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:8px 16px; font-size:13px; font-weight:500; text-decoration:none; margin-bottom:20px;">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>

    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:28px;">

        <h2 style="font-family:'Syne',sans-serif; font-weight:700; color:#1e293b; font-size:17px; margin:0 0 20px; padding-bottom:16px; border-bottom:1px solid #f1f5f9;">
            <i class="fa-solid fa-file-circle-plus" style="color:#1e40af; margin-right:8px;"></i>Nouveau procès-verbal
        </h2>

        <form action="{{ route('pvs.store') }}" method="POST"
              style="display:flex; flex-direction:column; gap:18px;">
            @csrf

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Soutenance <span style="color:#dc2626;">*</span></label>
                <select name="soutenance_id" required
                        style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                    <option value="">Sélectionner une soutenance...</option>
                    @foreach($soutenances as $s)
                    <option value="{{ $s->id }}" {{ old('soutenance_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->etudiant_prenom }} {{ $s->etudiant_nom }} — {{ \Carbon\Carbon::parse($s->date_soutenance)->format('d/m/Y') }}
                    </option>
                    @endforeach
                </select>
                @error('soutenance_id')<p style="color:#dc2626; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Note /20 <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="note" value="{{ old('note') }}" required
                           step="0.5" min="0" max="20" placeholder="Ex: 14.5"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                    @error('note')<p style="color:#dc2626; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Mention <span style="color:#dc2626;">*</span></label>
                    <select name="mention" required
                            style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                        @foreach(['Passable','Assez Bien','Bien','Très Bien'] as $m)
                        <option value="{{ $m }}" {{ old('mention') === $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Décision <span style="color:#dc2626;">*</span></label>
                <select name="decision" required
                        style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                    @foreach(['Admis','Ajourné','Admis avec réserves'] as $d)
                    <option value="{{ $d }}" {{ old('decision') === $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Appréciation</label>
                <textarea name="appreciation" rows="4"
                          placeholder="Appréciation générale du jury..."
                          style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; resize:none;">{{ old('appreciation') }}</textarea>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Date du PV <span style="color:#dc2626;">*</span></label>
                <input type="date" name="date_pv" value="{{ old('date_pv', date('Y-m-d')) }}" required
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; padding-top:16px; border-top:1px solid #f1f5f9;">
                <a href="{{ route('pvs.index') }}"
                   style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; text-decoration:none;">
                    Annuler
                </a>
                <button type="submit"
                        style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-file-circle-plus"></i> Créer le PV
                </button>
            </div>
        </form>
    </div>
</div>
@endsection