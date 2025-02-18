@extends('layout.user-layout')
@section('title', 'Demande individuelle de ' . Auth::user()->civilite . ' ' . Auth::user()->firstname . ' ' .
    Auth::user()->name)
@section('space-work')
    <section class="section profile">
        <div class="row justify-content-center">
            <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xs-12 col-xxl-12">
                @if ($message = Session::get('status'))
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" region="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($message = Session::get('success'))
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                        region="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                            role="alert">
                            <strong>{{ $error }}</strong>
                        </div>
                    @endforeach
                @endif
                <div class="card">
                    <div class="card-header text-center bg-gradient-default">
                        <h1 class="h4 text-black mb-0">Mes demandes ouvertes</h1>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="d-flex mt-2 align-items-baseline"><a href="#"
                                    class="btn btn-danger btn-sm text-white" title="décliner">Décliner</a>
                            </span>
                            <span class="d-flex mt-2 align-items-baseline"><a href="#"
                                    class="btn btn-success btn-sm text-white" title="valider">Valider</a>
                            </span>
                        </div>



                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">! Important</h5>
                                <p class="small fst-italic">Cher(e)
                                    <strong><em>{{ Auth::user()->firstname . ' ' . Auth::user()->name }}</em></strong>,
                                    Veuillez lire attentivement les informations concernant la formation. Il est important
                                    de <strong><em>confirmer</em></strong> votre
                                    présence pour confirmer votre participation. <br>Si vous ne souhaitez pas prendre part,
                                    n’oubliez pas de <strong><em>décliner</em></strong> votre invitation.
                                </p>

                                <h5 class="card-title">Informations</h5>

                                @foreach ($nouvelle_formations as $formation)
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Bénéficiaires</div>
                                        <div class="col-lg-9 col-md-8">{{ $formation?->name }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Module</div>
                                        @if (!empty($formation?->module?->name))
                                            <div class="col-lg-9 col-md-8">{{ $formation?->module?->name }}</div>
                                        @elseif(!empty($formation->collectivemodule->module))
                                            <div class="col-lg-9 col-md-8">{{ $formation->collectivemodule->module }}</div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Aucun</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Opérateur</div>
                                        @if (!empty($formation?->operateur?->user?->operateur))
                                            <div class="col-lg-9 col-md-8">{{ $formation?->operateur?->user?->operateur }}
                                                @if (!empty($formation?->operateur?->user?->username))
                                                    <strong><em>{{ '(' . $formation?->operateur?->user?->username . ')' }}</em></strong>
                                                @endif
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Aucun</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Date début</div>
                                        @if (!empty($formation?->date_debut))
                                            <div class="col-lg-9 col-md-8">{{ $formation?->date_debut->format('d/m/Y') }}
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Non définie</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Date fin</div>
                                        @if (!empty($formation?->date_fin))
                                            <div class="col-lg-9 col-md-8">{{ $formation?->date_fin->format('d/m/Y') }}
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Non définie</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Durée</div>
                                        @if (!empty($formation?->duree_formation))
                                            <div class="col-lg-9 col-md-8">{{ $formation?->duree_formation . ' jours' }}
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Non définie</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Lieu formation</div>
                                        @if (!empty($formation?->lieu))
                                            <div class="col-lg-9 col-md-8">
                                                {{ $formation?->lieu . ', ' . $formation?->departement?->nom }}
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Aucun</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Type de diplôme</div>
                                        @if (!empty($formation?->referentiel?->titre))
                                            <div class="col-lg-9 col-md-8">
                                                @if ($formation?->referentiel?->titre == 'Attestation')
                                                    {{ $formation?->referentiel?->titre }}
                                                @else
                                                    {{ $formation?->referentiel?->titre }}
                                                    @if (!empty($formation?->referentiel?->categorie))
                                                        {{ ', ' . $formation?->referentiel?->categorie }}
                                                    @endif
                                                    @if (!empty($formation?->referentiel?->convention?->name))
                                                        {{ ', de la ' . $formation?->referentiel?->convention?->name }}
                                                    @endif
                                                @endif
                                            </div>
                                        @else
                                            <div class="col-lg-9 col-md-8">Aucun</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <form>
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                            Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="assets/img/profile-img.jpg" alt="Profile">
                                            <div class="pt-2">
                                                <a href="#" class="btn btn-primary btn-sm"
                                                    title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm"
                                                    title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="fullName" type="text" class="form-control" id="fullName"
                                                value="Kevin Anderson">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                        <div class="col-md-8 col-lg-9">
                                            <textarea name="about" class="form-control" id="about" style="height: 100px">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="company" type="text" class="form-control" id="company"
                                                value="Lueilwitz, Wisoky and Leuschke">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="job" type="text" class="form-control" id="Job"
                                                value="Web Designer">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="country" type="text" class="form-control" id="Country"
                                                value="USA">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="address" type="text" class="form-control" id="Address"
                                                value="A108 Adam Street, New York, NY 535022">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="Phone"
                                                value="(436) 486-3538 x29071">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="Email"
                                                value="k.anderson@example.com">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter
                                            Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="twitter" type="text" class="form-control" id="Twitter"
                                                value="https://twitter.com/#">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook
                                            Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="facebook" type="text" class="form-control" id="Facebook"
                                                value="https://facebook.com/#">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram
                                            Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="instagram" type="text" class="form-control" id="Instagram"
                                                value="https://instagram.com/#">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin
                                            Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="linkedin" type="text" class="form-control" id="Linkedin"
                                                value="https://linkedin.com/#">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-settings">

                                <!-- Settings Form -->
                                <form>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email
                                            Notifications</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                                <label class="form-check-label" for="changesMade">
                                                    Changes made to your account
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                                <label class="form-check-label" for="newProducts">
                                                    Information on new products and services
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="proOffers">
                                                <label class="form-check-label" for="proOffers">
                                                    Marketing and promo offers
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="securityNotify"
                                                    checked disabled>
                                                <label class="form-check-label" for="securityNotify">
                                                    Security alerts
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End settings Form -->

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form>

                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control"
                                                id="currentPassword">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="newpassword" type="password" class="form-control"
                                                id="newPassword">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="renewpassword" type="password" class="form-control"
                                                id="renewPassword">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
