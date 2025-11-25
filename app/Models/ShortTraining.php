<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ShortTraining extends Model
    {
    use HasFactory;

            protected $fillable = [
            'training_id',
            'financier',
            'employer_name',
            'full_name',
            'id_no',
            'phone',
            'email',
            'national_id_path',
            'national_id_original_name',
            ];

    public function training()
    {
    return $this->belongsTo(\App\Models\Training::class);
    }
    }
