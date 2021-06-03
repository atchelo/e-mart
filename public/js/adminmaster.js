 function markread(id) {
 
  var a = $('#countNoti').text();
  $.ajax({
    url: baseUrl + "/usermarkreadsingle",
    type: "GET",
    data: {
      id1: id
    },
    success: function(result) {
      if(a > 0) {
        var b = a - 1;
        if(b > 0) {
          $('#countNoti').text(b);
          $('#' + id).css('background', 'white');
        } else {
          $('#countNoti').hide('fast');
        }
      }
    }
  });
}
   var name = 'tourNew' + Date.now().toString();

    var tour = new Tour({
        storage : window.localStorage,
        backdrop : true,
        container: "body",
        smartPlacement: true,
        autoscroll : true
    });
 
    tour.addSteps([
      
      {
        element: ".adminLogo",
        title: 'Welcome to '+appname,
        content: "Let's do a quick tour of application to introduce how it can be setup !",
        
      },

      {
        element: "#menum",
        title: '<b>Menu Management</b>',
        content: "Create various types of menu in menu management.",
        
      },


      {
        element: "#location",
        title: '<b>Location</b>',
        content: "Add different countries here and update pincode for delivery in respected city.",
        
      },

       {

        element: "#mscur",
        title: '<b>Manage your currency settings here</b>',
        content: "Create multiple currency and set geo location wise currency here.",
        
      },

      {

        element: "#shippingtax",
        title: '<b>Shipping and tax </b>',
        content: "Create multiple taxes and setup shipping setting here.",
        
      },

      {

        element: "#commission",
        title: '<b>Commission Settings</b>',
        content: "Update commission setting here eg. rates and type.",
        
      },

      {

      element: "#prom",
        title: '<b>Product Management and Other</b>',
        content: "Create brand, units,category, subcategory and childcategory, product, product options and variants, coupons, return policies here.",
        
      },

      {

      element: "#ordersm",
        title: '<b>Order management</b>',
        content: "Perform order related all operatins here eg. edit update order status.",
        
      },

      {

      element: "#martools",
        title: '<b>Marketing tools</b>',
        content: "Create advertise, hotdeals and create update testimonials here.",
        
      },

      {

      element: "#stour",
        title: '<b>Thats it ! :)</b>',
        content: "It's basic setup tour if you want to restart it click on this to restart it.",
        
      },


    ]);
 
    // Initialize the tour
    tour.init();
 
    // Start the tour
    tour.start();

    function starttour(){
      tour.restart();
    }
 