<?php
namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Collective;
use App\Models\Depart;
use App\Models\Individuelle;
use App\Models\Interne;
use App\Models\Operateur;
use App\Models\User;
use App\Models\Region;
use App\Models\Departement;
use App\Policies\CollectivePolicy;
use App\Policies\DepartementPolicy;
use App\Policies\DepartPolicy;
use App\Policies\IndividuellePolicy;
use App\Policies\InternePolicy;
use App\Policies\OperateurPolicy;
use App\Policies\RegionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class         => UserPolicy::class,
        Individuelle::class => IndividuellePolicy::class,
        Collective::class   => CollectivePolicy::class,
        Operateur::class    => OperateurPolicy::class,
        Interne::class      => InternePolicy::class,
        Depart::class       => DepartPolicy::class,
        Region::class       => RegionPolicy::class,
        Departement::class  => DepartementPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        /*  $this->registerPolicies();

        Gate::define('view-dashboard', function ($user) {
            return $user->isAdmin();
        }); */

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('ONFP | Confirmation du compte')
                ->line('Vous venez de créer un compte sur la plate-forme SIGOF(Système intégré de Gestion des opérations de Formation) de l\'ONFP. Pour activer votre compte il vous suffit de cliquer sur ce lien.')
                ->action('Valider mon compte', $url);
        });
    }
}
