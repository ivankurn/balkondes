var nodeID;
var rootURL;
var selectedID;
var parentID;

$(document).ready(function(){
  rootURL = $("#root-url").val() + '/';

  $("#tree_3").bind('move_node.jstree', function(e, data) {
      try{
        var movedID     = $("#" + data.node.id).attr('data-id');
        var oldParentID = $("#" + data.old_parent).attr('data-id');
        var newParent   = $("#" + data.parent).attr('data-id');
        var name        = data.node.text;

        $.ajax({
            url: rootURL + 'ajax/category/edit',
            type: 'POST',
            data: {
              id_parent     : newParent,
              id_kategori   : movedID,
              nama_kategori : name
            },
            dataType: 'json',
            beforeSend: function(){
              waitingDialog.show('Moving...');
            },
            success: function(result){
              waitingDialog.hide();
              if(result['status'] == 'success'){
              }

              if(result['status'] != 'success'){
                $("#error-title").html('Error!');
                var append = "";
                for(var i = 0 ; i < result['messages'].length ; i++){
                  append += '- ' + result['messages'][i] + '<br/>';
                }
                $("#error-content").html(append);
                $("#ajax-error").modal('show');
              }
            },
            error: function(xhr){
              if(xhr.statusText != "OK"){
                $("#error-title").html('Error !')
                $("#error-content").html(xhr.statusText);
                $("#ajax-error").modal('show');
              }
            }
        });
      }
      catch(err){
        $("#error-title").html('Error !')
        $("#error-content").html("Cannot be moved as as root category! <br/>Please undo your action!");
        $("#ajax-error").modal('show');
      }


  });

  $("#tree_3").jstree().bind("select_node.jstree", function (e, data) {
       var href = data.node.a_attr.href;
       window.open( data.node.a_attr.href, data.node.a_attr.target )
  });

  $("#tree_3").on('rename_node.jstree', function(e, data) {
    var old = data.old;
    var parent = $("#" + data.node.parent).attr('data-id');
    console.log('parent : ' + data.node.parent);
    if(nodeID){
      $.ajax({
          url: rootURL + 'ajax/category/edit',
          type: 'POST',
          data: {
            id_kategori     : nodeID,
            nama_kategori   : data.text,
            id_parent       : parent
          },
          dataType: 'json',
          beforeSend: function(){
            waitingDialog.show('Updating...');
          },
          success: function(result){
            waitingDialog.hide();
            if(result['status'] == 'success'){
              var a = $("#" + selectedID + '_anchor').html();
              var i = a.substring(0, a.indexOf('</i>') + 4);
              $("#" + selectedID + '_anchor').html(i + result['messages']['nama_kategori']);
            }

            if(result['status'] != 'success'){
              $("#error-title").html('Error!');
              var a = $("#" + selectedID + '_anchor').html();
              var i = a.substring(0, a.indexOf('</i>') + 4);
              $("#" + selectedID + '_anchor').html(i + old);
              var append = "";
              for(var i = 0 ; i < result['messages'].length ; i++){
                append += '- ' + result['messages'][i] + '<br/>';
              }
              $("#error-content").html(append);
              $("#ajax-error").modal('show');
            }
          },
          error: function(xhr){
            if(xhr.statusText != "OK"){
              var a = $("#" + selectedID + '_anchor').html();
              var i = a.substring(0, a.indexOf('</i>') + 4);
              $("#" + selectedID + '_anchor').html(i + old);
              $("#error-title").html('Error !')
              $("#error-content").html(xhr.statusText);
              $("#ajax-error").modal('show');
            }
          }
      });
    }
    else{
      var parent = $("#" + parentID).attr('data-id');
      if(parent == '#') parent = 0;
      $.ajax({
          url: rootURL + 'ajax/category/create',
          type: 'POST',
          data: {id_parent: parent, nama_kategori: data.text},
          dataType: 'json',
          beforeSend: function(){
            waitingDialog.show('Creating...');
          },
          success: function(result){
            waitingDialog.hide();
            if(result['status'] == 'success'){
              var a = $("#" + selectedID + '_anchor').html();
              var i = a.substring(0, a.indexOf('</i>') + 4);
              $("#" + selectedID + '_anchor').html(i + result['messages']['nama_kategori']);

              $("#" + selectedID).attr('data-id', result['messages']['id']);
              console.log($("#" + selectedID).attr('data-id'))
              location.reload();
            }
            if(result['status'] != 'success'){
              $("#error-title").html('Error!');
              var append = "";
              for(var i = 0 ; i < result['messages'].length ; i++){
                append += '- ' + result['messages'][i] + '<br/>';
              }
              $("#error-content").html(append);
              $("#ajax-error").modal('show');
            }
          },
          error: function(xhr){
            if(xhr.statusText != "OK"){
              data.text = data.old;
              $("#error-title").html('Error !')
              $("#error-content").html(xhr.statusText);
              $("#ajax-error").modal('show');

            }
          }
      });
    }

});

  var UITree = function() {
  n = function() {
              $("#tree_3").jstree({
                  core: {
                      themes: {
                          responsive: !1
                      },
                      check_callback: true,
                  },
                  types: {
                      "default": {
                          icon: "fa fa-tag icon-state-warning icon-lg"
                      },
                      file: {
                          icon: "fa fa-tag icon-state-warning icon-lg"
                      }
                  },
                  state: {
                      key: "demo2"
                  },
                  "dnd" : {
                    drop_check: function(data){
                      console.log(data)
                    }
                  },
                  plugins: ["contextmenu", "dnd", "state", "types"],
                  "contextmenu":{
                    "items": function($node) {
                        var tree = $("#tree_3").jstree(true);
                        return {
                            "Create": {
                                "separator_before": false,
                                "separator_after": false,
                                "label": "Create",
                                "action": function (obj) {
                                    $node = tree.create_node($node);
                                    selectedID = $node;
                                }
                            },
                            "Rename": {
                                "separator_before": false,
                                "separator_after": false,
                                "label": "Rename",
                                "action": function (obj) {
                                    tree.edit($node);
                                    // console.log($node)
                                    parentID = $node.parents[0];
                                    selectedID = $node.id;
                                    if($node.data != null) nodeID = $node.data.id;
                                    else nodeID = null;


                                }
                            },
                            "Delete": {
                                "separator_before": false,
                                "separator_after": false,
                                "label": "Remove",
                                "action": function (obj) {
                                  children = $node.children.length;
                                  //console.log('id :' +$node.id)
                                  if(children > 0){
                                    $("#modal-title").html('Error!');
                                    $("#modal-content").html('Cannot delete a parent category!');
                                    $("#small").modal('show')
                                  }

                                  if($node.data.count > 0){
                                    $("#modal-title").html('Error!');
                                    $("#modal-content").html('Cannot delete a non-empty category!');
                                    $("#small").modal('show')
                                  }
                                  else {
                                    $.ajax({
                                      url: rootURL + 'ajax/category/delete',
                                      type: 'POST',
                                      data: {id_kategori: $node.data.id},
                                      dataType: 'json',
                                      beforeSend: function(){
                                        waitingDialog.show('Deleting...');
                                      },
                                      success: function(result){
                                        waitingDialog.hide();

                                        if(result['status'] != 'success'){

                                          $("#error-title").html('Error!');

                                          var append = "";
                                          for(var i = 0 ; i < result['messages'].length ; i++){
                                            append += '- ' + result['messages'][i] + '<br/>';
                                          }
                                          $("#error-content").html(append);
                                          $("#ajax-error").modal('show');
                                        }

                                        else tree.delete_node($node);
                                      },
                                      error: function(xhr){
                                        waitingDialog.hide();
                                        if(xhr.statusText != "OK"){
                                          $("#error-title").html('Error !')
                                          $("#error-content").html(xhr.statusText);
                                          $("#ajax-error").modal('show');
                                        }
                                      }
                                    });
                                  }
                                    //tree.delete_node($node);
                                }
                            }
                        };
                    }
                }
              })
          }
      return {
          init: function() {
            n()
          }
      }
  }();
  App.isAngularJsApp() === !1 && jQuery(document).ready(function() {
      UITree.init()
  });
});
