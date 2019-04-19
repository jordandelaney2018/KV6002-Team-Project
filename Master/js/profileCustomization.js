function printPosts( amount ) {

    var i = 0;
    while( i < amount){
        document.write("<div class=\"post\">\n" +
            "\n" +
            "            </div>");
    i++
    }
}

// Changes the class of the elements on the profile page in order to change the colour
function changeBannerColour(colour){
    if(colour == 1){

        $("#profileTopSectionLeft").removeClass();
        $("#profileTopSectionLeft").addClass("profilePink");

        $("#profileTopSectionRight").removeClass();
        $("#profileTopSectionRight").addClass("profilePink");

        $("#aboutMe").removeClass();
        $("#aboutMe").addClass("aboutMe");

        $("#details").removeClass();
        $("#details").addClass("details");

        $("#profilePersonal").removeClass();
        $("#profilePersonal").addClass("pinkBorder");

        $("#profilePosts").removeClass();
        $("#profilePosts").addClass("pinkBorder");
    }
    else if(colour == 2){

        $("#profileTopSectionLeft").removeClass();
        $("#profileTopSectionLeft").addClass("profileBlue");


        $("#profileTopSectionRight").removeClass();
        $("#profileTopSectionRight").addClass("profileBlue");

        $("#aboutMe").removeClass();
        $("#aboutMe").addClass("aboutBlue");

        $("#details").removeClass();
        $("#details").addClass("detailsBlue");

        $("#profilePersonal").removeClass();
        $("#profilePersonal").addClass("blueBorder");

        $("#profilePosts").removeClass();
        $("#profilePosts").addClass("blueBorder");
    }
    else if(colour == 3){

        $("#profileTopSectionLeft").removeClass();
        $("#profileTopSectionLeft").addClass("profileYellow");


        $("#profileTopSectionRight").removeClass();
        $("#profileTopSectionRight").addClass("profileYellow");

        $("#aboutMe").removeClass();
        $("#aboutMe").addClass("aboutYellow");

        $("#details").removeClass();
        $("#details").addClass("detailsYellow");

        $("#profilePersonal").removeClass();
        $("#profilePersonal").addClass("yellowBorder");

        $("#profilePosts").removeClass();
        $("#profilePosts").addClass("yellowBorder");

    }
    else if(colour == 4){

        $("#profileTopSectionLeft").removeClass();
        $("#profileTopSectionLeft").addClass("profileGreen");


        $("#profileTopSectionRight").removeClass();
        $("#profileTopSectionRight").addClass("profileGreen");

        $("#aboutMe").removeClass();
        $("#aboutMe").addClass("aboutGreen");

        $("#details").removeClass();
        $("#details").addClass("detailsGreen");

        $("#profilePersonal").removeClass();
        $("#profilePersonal").addClass("greenBorder");

        $("#profilePosts").removeClass();
        $("#profilePosts").addClass("greenBorder");
    }
    else if(colour == 5){

        $("#profileTopSectionLeft").removeClass();
        $("#profileTopSectionLeft").addClass("profileRed");


        $("#profileTopSectionRight").removeClass();
        $("#profileTopSectionRight").addClass("profileRed");

        $("#aboutMe").removeClass();
        $("#aboutMe").addClass("aboutRed");

        $("#details").removeClass();
        $("#details").addClass("detailsRed");

        $("#profilePersonal").removeClass();
        $("#profilePersonal").addClass("redBorder");

        $("#profilePosts").removeClass();
        $("#profilePosts").addClass("redBorder");
    }


}