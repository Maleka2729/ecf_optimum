<?php
/*
Template Name: yoga
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

<div class="container-fluid mb-3 bckimg_yoga">
  <div style="margin:4%;"></div>
  <div class="card" style="max-width: 25%; margin: 11% 0 0 10%;">
      <div class="col-md-12">
        <div class="card-body">
          <h2 class="card-title" style="font-size: 3em;">Seance de Yoga</h2>
          <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
            has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
            type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
            leap into electronic typesetting, remaining essentially unchanged.</p>
          <ul>
            <li>PRIX : 5000 XPF / SEANCE</li>
            <li>PLACES : 6 </li>
          </ul>
        </div>
      </div>
  </div>

</div>

<?php get_footer() ?>