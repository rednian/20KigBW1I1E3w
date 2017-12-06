<script src="">
  /**
   * Created by RedZ on 11/08/2017.
   */
//  var Person = function (config) {
//   this.name = config.name;
//   this.age = config.age;
//   this.occupation = config.occupation;
// };
//
//  Person.prototype.work = function () {
//    this.name + 'working';
//  };

  (function () {

    window.App = {
      Models:{},
      Collections:{},
      Views:{}
    };

    // window.template = function (id) {
    //   return _.template($('#'+id).html());
    // };

    // App.Models.User = Backbone.Model.extend({});
    // App.Views.User = Backbone.View.extend({});




    // App.Collections.User = Backbone.Collection.extend({});



  })();

  var User = Backbone.Model.extend({
    defaults:{
      user_id:'',
      username:'',
      password:'',
      firstname:'',
      middlename:'',
      lastname:'',
      department:'',
      position:'',
      status:'',
      image:'',
      dep_id:'',
      user_type_id:''
    },
//    urlRoots:'cpanel/userList'
  });






</script>