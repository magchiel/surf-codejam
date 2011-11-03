<script type="text/os-data" xmlns:os="http://ns.opensocial.org/2008/markup">
    <os:HttpRequest key="data" href="http://codejam.dev.local/content/devcon/getdai/data.json" format="json"/>
</script>
<div id="dairesult">Not found</div>
<script type="text/javascript">
    
    //just handy
     function $(string)
     {
     return document.getElementById(string); 
     }

    //gadgets.util.registerOnLoadHandler(fetchData)
    
    //Fetch datacontext with DAI contacts
    var datacontext = opensocial.data.getDataContext().getDataSet('data');
    
    //Fetch container profile    
    osapi.people.get({userId: '@viewer', fields: ['organizations','dai']}).execute(profileCallback);
    
    function profileCallback(profiledata)
    {
        
        var primaryorg = profiledata['organizations'][0]['name'];
        var dai = profiledata['dai'];
        
        var daiContactId = datacontext['result']['content']['contacts'][primaryorg];       
        
        var narcisquery = 'http://www.narcis.nl/search?coll=person&uquery='
        
        
        if(dai != null) {
            $('dairesult').innerHTML = 'Je DAI is <a target="_blank" href="' + narcisquery + dai + '">' + dai + ' (zoek in NARCIS).</a> ';
        }
        else {
            $('dairesult').innerHTML = 'Je hebt nog geen DAI aan je profiel gekoppeld. \n\
                <a onClick="notifyDaiContact(\'' + daiContactId + '\');">Vraag de DAI contactpersoon van je instelling om een DAI</a>';
        }
        
        gadgets.window.adjustHeight();
    }
    
        
    function notifyDaiContact(daiContactId)
    {
        var message = 'John DAI vraagt om een een DAI. ';
        console.log('send to: ' + daiContactId)
        osapi.messages.create({
            userId : daiContactId,
            entity : {
                title : 'DAI aanvraag',
                body : message,
                senderId : 'john.doe'   
            }}).execute(notifyCallback);
        
        //osapi.people.get({userId: daiContactId, fields: ['name']}).execute(daiContactCallback);
    }
    
    function notifyCallback(response)
    {
        //console.log(response);
    }
    
</script>