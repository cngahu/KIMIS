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
            'home_county_id',
            'current_county_id',
            'current_subcounty_id',
            'postal_code_id',
            'postal_address',
            'co',
            'town',
            ];

    public function training()
    {
    return $this->belongsTo(\App\Models\Training::class);
    }

        public function homeCounty()
        {
            return $this->belongsTo(County::class, 'home_county_id');
        }

        public function currentCounty()
        {
            return $this->belongsTo(County::class, 'current_county_id');
        }

        public function currentSubcounty()
        {
            return $this->belongsTo(Subcounty::class, 'current_subcounty_id');
        }

        public function postalCode()
        {
            return $this->belongsTo(PostalCode::class, 'postal_code_id');
        }
    }
