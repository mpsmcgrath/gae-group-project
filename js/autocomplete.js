//these are the autocomplete scripts for text input boxes.
//they work using typeahead.js also in the /js/ folder
//adapted from http://www.tutorialrepublic.com/twitter-bootstrap-tutorial/bootstrap-typeahead.php



$(document).ready(function(){
    // Sonstructs the suggestion engine
    var countries = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // The url points to a json file that contains an array of country names
        prefetch: './api/users/locations'
    });
    
    // Initializing the typeahead with remote dataset without highlighting
    $('.typeahead-location').typeahead(null, {
        name: 'countries',
        source: countries,
        limit: 10 /* Specify max number of suggestions to be displayed */
    });

    // Sonstructs the suggestion engine
    var subjects = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // The url points to a json file that contains an array of country names
        prefetch: './api/users/subjects'
    });
    
    // Initializing the typeahead with remote dataset without highlighting
    $('.typeahead-subject').typeahead(null, {
        name: 'subjects',
        source: subjects,
        limit: 10 /* Specify max number of suggestions to be displayed */
    });
});  