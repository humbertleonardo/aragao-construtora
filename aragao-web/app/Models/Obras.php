<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obras extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_usuario',
        'nome',
        'dt_inicio',
        'dt_termino',
        'dt_previsao_termino',
        'endereco_rua',
        'endereco_bairro',
        'endereco_numero',
        'endereco_cidade',
        'endereco_uf',
        'endereco_cep',
        'tipo_recurso',
        'descricao_completa',
        'valor'
    ];

    protected $appends = [
        'status',
        'valor_quitado',
        'valor_aberto',
        'valor_vencido'
    ];

    protected static function boot() {
        parent::boot();

        static::deleting(function($obra) {
            ObrasUsuarios::where('id_obra', $obra->id)->delete();
        });
    }

    public function getStatusAttribute() {
        $status = 'Concluida';
        $dtPrevisao = Carbon::parse($this->dt_previsao_termino);

        if (now()->gt($dtPrevisao) && !$this->dt_termino) $status = 'Atrasada';
        else if (now()->lt($dtPrevisao) && !$this->dt_termino) $status = 'Em andamento';

        return $status;
    }

    public function getValorQuitadoAttribute() {
        return ObrasEtapas::where('id_obra', $this->id)
            ->where('quitada', true)->get()
            ->sum('valor_etapa');
    }

    public function getValorAbertoAttribute() {
        return ObrasEtapas::where('id_obra', $this->id)
            ->where('quitada', false)
            ->where('dt_vencimento', '>', date('Y-m-d'))->get()
            ->sum('valor_etapa');
    }
    
    public function getValorVencidoAttribute() {
        return ObrasEtapas::where('id_obra', $this->id)
            ->where('quitada', false)
            ->where('dt_vencimento', '<', date('Y-m-d'))->get()
            ->sum('valor_etapa');
    }
}
