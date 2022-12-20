$(document).ready(function () {
  
    // var names = [
    //   { name : "index.php",id: "index"},
    //   { name : "project.php",id: "project"},
    //   { name : "about.php",id: "about"},
    //   { name : "services.php",id: "services"},
    //   { name : "pricing.php",id: "pricing"},
    //   { name : "faq.php",id: "faq"},
    //   { name : "contact.php",id: "contact"},
    //   { name : "how_to_work.php",id: "how_to_work"}
    //  ];
     
     
  var filteredNames = $(NavName).filter(function( idx ) {
      return names[idx].name === document.location.pathname.match(/[^\/]+$/)[0];
  }); 
  
  $(filteredNames).each(function(){
      // $('#output').append(this.name);
      console.log(this.name);
      console.log(this.id);
      $("#"+this.id).attr('class', 'active');
   
  });
  
   
  });
  