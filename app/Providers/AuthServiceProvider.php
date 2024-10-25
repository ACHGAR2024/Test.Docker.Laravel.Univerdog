<?php

use Laravel\Passport\Passport; 

class AuthServiceProvider extends ServiceProvider { public function boot() { $this->
    registerPolicies();

    Passport::routes(); // Ajoutez cette ligne pour les routes Passport
    }
    }