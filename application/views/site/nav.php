<?php
  echo '<h3 class="nav__user-info">';
  echo $user;
  echo ' - Access level: ';
  echo $al;
  echo '</h3>';
 ?>

<div class="nav__bar">
  <ul class="nav nav-pills nav-stacked">
    <?php if ($al == 1) { echo '<li class="nav__item" role="presentation"><a>Staff</a></li>'; } ?>
    <li class="nav__item" role="presentation"><a>Therapy</a></li>
    <li class="nav__item" role="presentation"><a>Room</a></li>
    <li class="nav__item" role="presentation"><a>Equipment</a></li>
  </ul>
</div>