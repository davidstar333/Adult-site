$.get(appSettings.BASE_URL+'/lib/jquery/src/emoticons.json', function(smiles){
    $.emoticons.define(smiles);
})
