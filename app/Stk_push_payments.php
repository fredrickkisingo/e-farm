<?php
    namespace App;
    use Illuminate\Database\Eloquent\Model;
    
    class Stk_push_payments extends Model
    {
        protected $table ='stk_push_payments';
        
        public function user(){
            return $this->belongsTo('App\User');
        }
    }
?>
