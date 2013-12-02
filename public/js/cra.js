// Tableau

/*
 * Utilisation :  
 *  1. Créer un tableau avec la proprieté class="dTable" (Dynamic TABLE)
 *  2. Le tableau doit être standard : il contenir un <thead>, un <tbody> et un <tfoot>
 *     et utiliser à bon escient les <td> et <th>.
 *  3. La première ligne du tbody sera utilisée comme ligne de réference.
 *     Elle sera clonée pour en ajouter de nouvelle. Elle ne sera pas affichée. 
 *
window.onload = dtableInit;

/* initialise le script 
function dtableInit() {
	var table = document.getElementsByTagName('TABLE');
	for ( var i = 0; i < table.length; i++ ) {
		// on récupère tous les tableaux dynamiques
		if ( table[i].className = 'dTable' ) {
			var tbody = table[i].tBodies[0];
			var newTr = tbody.rows[0].cloneNode(true);
			
			// on masque la première ligne du tbody (la ligne de reference)
			tbody.rows[0].style.display = 'none';
			
			// on en ajoute une
			tbody.appendChild(newTr);
		}
	}
}

*/
//trouve le tag "parentTagName" parent de "element" 
function getParent(element, parentTagName) {
	if ( ! element )
		return null;
	else if ( element.nodeType == 1 && element.tagName.toLowerCase() == parentTagName.toLowerCase() )
		return element;
	else
		return getParent(element.parentNode, parentTagName);
}

// ajoute une ligne
function addLigne() {
	var table = document.getElementById('tableau');
	
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	
	var newRowId = 'ligne_' + (rowCount-1); //-1 car il y a le <tr> du <thead> dans la liste
	row.id = newRowId;
	
	var colCount = table.rows[1].cells.length; //l'indice de la première ligne est 1 et non 0 à cause du <tr> dans le <thead>
	for(var i=0; i<colCount; i++) {
	    
        var newCell = row.insertCell(i);

        newCell.innerHTML = table.rows[1].cells[i].innerHTML;  
        
        switch(newCell.childNodes[0].type) {
            case "date":
            case "text":
                newCell.childNodes[0].value = "";
                newCell.childNodes[0].readonly = false;
                break;
            case "hidden":
                newCell.childNodes[0].value = "0";
                newCell.childNodes[0].readonly = false;
                break;
            case "checkbox":
                newCell.childNodes[0].checked = false;
                newCell.childNodes[0].readonly = false;
                break;
            case "select-one":
                newCell.childNodes[0].selectedIndex = 0;
                newCell.childNodes[0].readonly = false;
                break;
        }
	}
	
	//Workaround for new line
	$('#' + newRowId + ' input[type=date]').attr('readonly', false).val('');
}

function addCol() {
	var table = document.getElementById('tableau');

	var colCount = table.col.length;
	var col = table.insertCol(colCount);
}

//supprimer une ligne 
function delLigne(link) {
    var table = document.getElementById('tableau');
    
    var rowCount = table.rows.length;
    // 2 car il y a la ligne dans le thead.
    if (rowCount <= 2) {
        alert('Vous ne pouvez pas supprimer la dernière ligne de ce tableau.');
        return false;
    }
    
    var deletingRowIndex = getParent(link, 'tr').rowIndex;
    table.deleteRow(deletingRowIndex);
}