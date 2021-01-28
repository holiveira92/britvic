<?php

namespace App\Rules;
use App\Models\Reserva;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class Reservado implements Rule
{   
    private $request;
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {   
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $reservas_data = Reserva::getReservasByDateUser($this->request->veiculo_id,$this->request->data_inicio,$this->request->data_fim,$this->request->id);
        if(!empty($reservas_data)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Não é possível realizar esta reserva. Veículo indisponível nesta data, favor selecionar após ' . date("d/m/Y",strtotime($this->request->data_fim));
    }
}
