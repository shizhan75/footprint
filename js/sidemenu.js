$(function() {
  document.body.appendChild($(`
  <div id="sidemenu-wrapper">
    <button type="button" class="btn btn-default" aria-label="Menu" id="btnShowSideMenu">
      <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
    </button>
    <div class="overlay" style="display: none">
      <nav class="sidebar-nav">
        <ul class="metismenu" id="menu1">
          <li class="metismenu-header">
          <span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;Uguisudani
          </li>
          <li class="mm-active">
            <a class="has-arrow" href="#">Maps</a>
            <ul>
              <li>
                <a href="map.php?map=china">China</a>
                <a href="map.php?map=japan">Japan</a>
              </li>
              </ul>
          </li>
          <li><a href="footprint.php">Footprint manager</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </div>
  </div>
  `)[0]);
  $("#menu1").metisMenu({ toggle: false });
  $('.overlay').click((e) => {
    if (e.offsetX <= $('.sidebar-nav')[0].offsetWidth) return;
    $('.overlay').hide();
    $('#btnShowSideMenu').show();
  });
  $('#btnShowSideMenu').click(() => {
    $('.overlay').show();
    $('#btnShowSideMenu').hide();
    return false;
  });
});