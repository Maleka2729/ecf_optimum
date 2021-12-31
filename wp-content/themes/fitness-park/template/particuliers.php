<?php
/*
Template Name: cours particuliers
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
<div style="margin:3%;"></div>
<div class="container-fluid mt-5 mb-3">
  <div class="card" style="max-width: 75%; margin:auto;">
    <div class="row g-0">

      <div class="col-md-6">
        <img src="http://localhost/ecf_optimum/wp-content/uploads/2021/12/renforcement_muscu.jpg"
          class="img-fluid rounded-start" alt="...">
      </div>

      <div class="col-md-6">
        <div class="card-body">
          <h3 class="card-title">Renforcement musculaire</h3>
          <p class="card-text" >Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
            has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
            type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
            leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the
            release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
            software like Aldus PageMaker including versions of Lorem Ipsum.</p>
          <ul>
            <li>PRIX : 6000 XPF / SEANCE</li>
          </ul>
        </div>
      </div>

    </div>
  </div>

</div>

<div style="margin:8%;"></div>

<div class="container-fluid mb-3">
  <div class="card" style="max-width: 75%; margin:auto;">
    <div class="row g-0">
      <div class="col-md-6">
        <div class="card-body">
          <h3 class="card-title">Preparation physique</h3>
          <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
            has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
            type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
            leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the
            release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
            software like Aldus PageMaker including versions of Lorem Ipsum.</p>
          <ul>
            <li style="margin-left: 1%;">PRIX : 6000 XPF / SEANCE</li>
          </ul>
        </div>
      </div>

      <div class="col-md-6">
        <img src="http://localhost/ecf_optimum/wp-content/uploads/2021/12/preparation-physique.jpg"
          class="img-fluid rounded-start" alt="...">
      </div>
    </div>
  </div>

</div>

<div style="margin:3%;"></div>

<?php get_footer() ?>