"use strict";
// Define your library strictly...
function warning() {
  setTimeout(function() {
    var animateIn = "lightSpeedIn";
    var animateOut = "lightSpeedOut";
    PNotify.notice({
      title: 'Warning',
      text: warningmsg,
      icon: 'fa fa-exclamation-triangle',
      modules: {
        Animate: {
          animate: true,
          inClass: animateIn,
          outClass: animateOut
        }
      }
    });
  }, 1500);
}

function deleted() {
  setTimeout(function() {
    var animateIn = "lightSpeedIn";
    var animateOut = "lightSpeedOut";
    PNotify.error({
      title: 'Deleted',
      text: deletedmsg,
      icon: 'fa fa-trash',
      modules: {
        Animate: {
          animate: true,
          inClass: animateIn,
          outClass: animateOut
        }
      }
    });
  }, 1500);
}

function update() {
  setTimeout(function() {
    var animateIn = "lightSpeedIn";
    var animateOut = "lightSpeedOut";
    PNotify.success({
      title: 'Updated',
      text: updatedmsg,
      icon: 'fa fa-check-circle-o',
      modules: {
        Animate: {
          animate: true,
          inClass: animateIn,
          outClass: animateOut
        }
      }
    });
  }, 1500);
}

function success() {
  setTimeout(function() {
    var animateIn = "lightSpeedIn";
    var animateOut = "lightSpeedOut";
    PNotify.success({
      title: 'Added',
      text: addedmsg,
      icon: 'fa fa-check-circle',
      modules: {
        Animate: {
          animate: true,
          inClass: animateIn,
          outClass: animateOut
        }
      }
    });
  }, 1500);
}