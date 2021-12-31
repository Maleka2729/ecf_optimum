<?php
/*
Template Name: offres 
*/
get_header();
    if (!is_front_page() || !is_home()) {
        /**
         * @hook fitness_park_breadcrumbs.
         *
         * @hooked fitness_park_breadcrumbs.
         *
         */
        do_action('fitness_park_breadcrumbs');
    }


?>

<div class="container mb-3">
    <div class="card text-center" style="width: 18rem; display:contents;">
        <div class="card-body">
            <h3 class="card-title">Avec OPTIMUM, vous avez le choix !</h3>
            <p class="card-text">
               RETROUVEZ NOS DIFFERENTES OFFRES 
            </p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-5">
            <div class="card">
                <img src="http://localhost/ecf_optimum/wp-content/uploads/2021/12/mensuel.jpg" class="card-img-top" alt="..." />
                <div class="card-body">
                    <h4 class="card-title">ABONNEMENT MENSUEL</h4>
                    <p class="card-text">
                        Accès à la salle de musculation <br>
                        PRIX : 9000 XPF / MOIS
                    </p>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card">
                <img src="http://localhost/ecf_optimum/wp-content/uploads/2021/12/annuelle.jpg" class="card-img-top" alt="..." />
                <div class="card-body">
                    <h4 class="card-title">ABONNEMENT ANNUEL</h4>
                    <p class="card-text">
                    Accès à la salle de musculation <br>
                        PRIX : 110 000 XPF / ANNEE
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php echo do_shortcode("[abonnement_course_form]"); ?>


</div>

<?php get_footer() ?>