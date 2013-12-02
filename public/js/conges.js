function temps(date)
{
	var d = new Date(date[2], date[1] - 1, date[0]);
	return d.getTime();
}

function calculer() 
{ 

	var date1=document.forms['form1'].elements['date1'].value
	var date2=document.forms['form1'].elements['date2'].value

	var debut = temps(date1);
	var fin = temps(date2);
	var nb = (fin - debut) / (1000 * 60 * 60 * 24); // + " jours";
	document.forms['form1'].elements['jour'].value=nb;
} 


function addLigne()
{
	var tableau = document.getElementById("tableau");
    var ligne = tableau.insertRow(1);//on a ajouté une ligne
    for(var i = 0; i < 14; i++)
    {
    	switch(i)
    	{
    		case 0:
    			ligne.insertCell(i).innerHTML += "<input type='date' name='date1'/>";
    		break;
    		case 1:
    			ligne.insertCell(i).innerHTML += "<input type='date' name='date2'/>";
    		break;
    		case 2:
    			ligne.insertCell(i).innerHTML += "<input type='text' name='jour' value='0' readonly />";
    		break;
    		case 3:
    			ligne.insertCell(i).innerHTML += "<span></span>";
    		break;
    	} 	
    }
}

function delLigne(num)
{
    document.getElementById("tableau").deleteRow(num);
}