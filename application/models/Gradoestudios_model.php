<?php
    class Gradoestudios_model extends My_Model 
    {
        protected $_table = 'nogradoestudios'; 
        protected $primary_key ='id_gradoestudios';
        
        function Gradoestudio_model() 
        {
            parent::__construct();
        }
        
    } // fin de Gradoestudio_model