<style>
  .drawer {
  display: none;
}
.drawer__header {
  padding: 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  /* border-bottom: 1px solid #ddd; */
}

.drawer__close {
  margin: 0;
  padding: 0;
  border: none;
  background-color: transparent;
  cursor: pointer;
  background-image: url("data:image/svg+xml,%0A%3Csvg width='15px' height='16px' viewBox='0 0 15 16' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3E%3Cg id='Page-1' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'%3E%3Cg id='2.-Menu' transform='translate(-15.000000, -13.000000)' stroke='%23000000'%3E%3Cg id='Group' transform='translate(15.000000, 13.521000)'%3E%3Cpath d='M0,0.479000129 L15,14.2971819' id='Path-3'%3E%3C/path%3E%3Cpath d='M0,14.7761821 L15,-1.24344979e-14' id='Path-3'%3E%3C/path%3E%3C/g%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  width: 15px;
  height: 15px;
}

.drawer__wrapper {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  height: 100%;
  width: 100%;
  max-width: 750px;
  z-index: 9999;
  overflow: auto;
  transition: transform 0.3s;
  will-change: transform;
  background-color: #fff;
  display: flex;
  flex-direction: column;
  -webkit-transform: translateX(103%);
  transform: translateX(103%); /* extra 3% because of box-shadow */
  -webkit-overflow-scrolling: touch; /* enables momentum scrolling in iOS overflow elements */
  box-shadow: 0 2px 6px #777;
}

.drawer__content {
  position: relative;
  overflow-x: hidden;
  overflow-y: auto;
  height: 100%;
  flex-grow: 1;
  padding: 1.5rem;
}

.drawer.is-active {
  display: block;
}

.drawer.is-visible .drawer__wrapper {
  -webkit-transform: translateX(0);
  transform: translateX(0);
}

.drawer.is-visible .drawer__overlay {
  opacity: 0.5;
}
.drawer__overlay {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 100%;
  z-index: 2000;
  opacity: 0;
  transition: opacity 0.3s;
  will-change: opacity;
  background-color: #000;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
</style>

<script type="text/javascript">
  $(document).ready(function() {
    var url = window.location.href;
    if (url.indexOf("prod_data"))
    {
        $('a#fab.btn-floating.btn-lg.btn-success').css("padding-top","inherit");
        // $('a#fab.btn-floating.btn-lg.btn-success').addClass("");
    }
  });
  var drawer = function () {

    /**
    * Element.closest() polyfill
    * https://developer.mozilla.org/en-US/docs/Web/API/Element/closest#Polyfill
    */
    if (!Element.prototype.closest) {
      if (!Element.prototype.matches) {
        Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
      }
      Element.prototype.closest = function (s) {
        var el = this;
        var ancestor = this;
        if (!document.documentElement.contains(el)) return null;
        do {
          if (ancestor.matches(s)) return ancestor;
          ancestor = ancestor.parentElement;
        } while (ancestor !== null);
        return null;
      };
    }


    //
    // Settings
    //
    var settings = {
      speedOpen: 50,
      speedClose: 350,
      activeClass: 'is-active',
      visibleClass: 'is-visible',
      selectorTarget: '[data-drawer-target]',
      selectorTrigger: '[data-drawer-trigger]',
      selectorClose: '[data-drawer-close]',

    };


    //
    // Methods
    //

    // Toggle accessibility
    var toggleccessibility = function (event) {
      if (event.getAttribute('aria-expanded') === 'true') {
        event.setAttribute('aria-expanded', false);
      } else {
        event.setAttribute('aria-expanded', true);
      }
    };

    // Open Drawer
    var openDrawer = function (trigger) {

      // Find target
      var target = document.getElementById(trigger.getAttribute('aria-controls'));

      // Make it active
      target.classList.add(settings.activeClass);

      // Make body overflow hidden so it's not scrollable
      document.documentElement.style.overflow = 'hidden';

      // Toggle accessibility
      toggleccessibility(trigger);

      // Make it visible
      setTimeout(function () {
        target.classList.add(settings.visibleClass);
      }, settings.speedOpen);

    };

    // Close Drawer
    var closeDrawer = function (event) {

      // Find target
      var closestParent = event.closest(settings.selectorTarget),
        childrenTrigger = document.querySelector('[aria-controls="' + closestParent.id + '"');

      // Make it not visible
      closestParent.classList.remove(settings.visibleClass);

      // Remove body overflow hidden
      document.documentElement.style.overflow = '';

      // Toggle accessibility
      toggleccessibility(childrenTrigger);

      // Make it not active
      setTimeout(function () {
        closestParent.classList.remove(settings.activeClass);
      }, settings.speedClose);

    };

    // Click Handler
    var clickHandler = function (event) {

      // Find elements
      var toggle = event.target,
        open = toggle.closest(settings.selectorTrigger),
        close = toggle.closest(settings.selectorClose);

      // Open drawer when the open button is clicked
      if (open) {
        openDrawer(open);
      }

      // Close drawer when the close button (or overlay area) is clicked
      if (close) {
        closeDrawer(close);
      }

      // Prevent default link behavior
      if (open || close) {
        event.preventDefault();
      }

    };

    // Keydown Handler, handle Escape button
    var keydownHandler = function (event) {

      if (event.key === 'Escape' || event.keyCode === 27) {

        // Find all possible drawers
        var drawers = document.querySelectorAll(settings.selectorTarget),
          i;

        // Find active drawers and close them when escape is clicked
        for (i = 0; i < drawers.length; ++i) {
          if (drawers[i].classList.contains(settings.activeClass)) {
            closeDrawer(drawers[i]);
          }
        }

      }

    };


    //
    // Inits & Event Listeners
    //
    document.addEventListener('click', clickHandler, false);
    document.addEventListener('keydown', keydownHandler, false);


  };

  drawer();
</script>
<!-- Fixed Action Button -->
<div class="fixed-action-btn" style="bottom: 45px; right: 24px; z-index:1500;" name="add" id="add" data-drawer-trigger aria-controls="add_data_Modal" aria-expanded="false">
    <a class="btn-floating btn-lg btn-success mx-auto" name="fab" id="fab" data-toggle="tooltip" data-placement="left" title="Add New Entry" style="text-align: center!important;">
      <i class="lg-icon" data-feather="plus-circle" >add</i>
    </a>
    
  </div>
<!-- Fixed Action Button -->