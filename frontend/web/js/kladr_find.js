(function($){
    $(function() {
        var container = $('#main');
        //var city = container.find( '[name="city"]' );
	var city = 'Санкт-Петербург';
        var street = container.find( '[name="street"]' );
    	var build = container.find( '[name="build"]' );
    	var lab_street = container.find( '[name="lab_street"]' );
	var token = '578141d10a69de64658b4567'; //токен и ключ можно получить после регистрации на kladr-api.ru
	var key = '86a2c2a06f1b2451a87d05512cc2c3edfdf41969'; 
        
// Подключение автодополнения улиц
        street.kladr({
            token: token,
            key: key,
            type: $.kladr.type.street,
            parentType: $.kladr.type.city,
            parentId: city.val(),
            select: function( obj ) {
                build.kladr('parentId', obj.id);
                lab_street.text( obj.type + ':' );
            }
        });
		//подключение автодополнения зданий
    build.kladr({
            token: token,
            key: key,
            type: $.kladr.type.building,
            parentType: $.kladr.type.street,
            parentId: city.val()
        });
		//при клике по форме изменение родительского объекта для автодополнения улиц
        getelem('street').onkeypress = function(){
            street.kladr('parentId', city.val());
        }
		
        city.change(function changecity(){
            // Изменение родительского объекта для автодополнения улиц
            street.kladr('parentId', city.val());
			getelem('street').value = null;
			getelem('build').value = null;
        });
		function getelem(id){ return document.getElementById(id);}
    });
})(jQuery);
