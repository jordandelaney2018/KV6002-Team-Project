// Function runs
function searchq(){
    var searchtext = $("input[name='search']").val();


    $.post("search.php", {searchVal: searchtext}, function(output){
        $("#output").html(output);

    });
}
