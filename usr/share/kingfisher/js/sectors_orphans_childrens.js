/*

    Orphans user e Childrens user functions ( For Sectors )

*/


// Sectors

// Get Orphans
function get_orphans_sectors() {

	$.ajax({
				
		type: "GET",
		url: "./ajax/orphans_users.php",
		dataType: "xml",
		data: "type=sectors",
		success: function(xml) {
			get_orphans_result_sectors(xml);
		}

	});

}


// Alter orphans to childrens and childrens to orphans
function alter_or_ch_sectors(id, sector_id) {

	$.ajax({
				
		type: "GET",
		url: "./ajax/alter_or_ch_sectors.php",
		dataType: "html",
		data: "id=" + id + "&sector_id=" + sector_id,
		success: function(html) {
			update_state_sectors(html);
		}

	});

}


// Receive orphans list and show
function get_orphans_result_sectors(xml) {

	$('div#orphans_data').html('');

	$(xml).find('user').each(function() {
		
		var id_user = $(this).find('id').text();
		var name_user = $(this).find('name').text()
		var id_sector = $('input#sector').val();

		$('div#orphans_data').append('<li><a href="#" OnClick="alter_or_ch_sectors(' + id_user + ', ' + id_sector + ')">' + name_user + '</a></li>');		

	});

}


// Get childrens
function get_childrens_sectors() {

	$.ajax({
				
		type: "GET",
		url: "./ajax/childrens_users.php",
		dataType: "xml",
		data: "type=sectors&id=" + $("input#sector").val(),
		success: function(xml) {
			get_childrens_result_sectors(xml);
		}

	});

}


// Receive childrens list and show
function get_childrens_result_sectors(xml) {

	$('div#childrens_data').html('');

	$(xml).find('user').each(function() {

		var id_user = $(this).find('id').text();
		var name_user = $(this).find('name').text();

		$('div#childrens_data').append('<li><a href="#" OnClick="alter_or_ch_sectors(' + id_user + ', 1)">' + name_user + '</a></li>');

	});

}

// Update Viewer
function update_state_sectors() {
	get_orphans_sectors();
	get_childrens_sectors();
}


