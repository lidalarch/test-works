//Settings for Datepicker jQuery script

  $(function() {
    $( "#datepicker" ).datepicker({ dateFormat: "dd.mm.yy"});
  });

  $(function() {
$( "#datepicker" ).datepicker( "option", "monthNames", [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ] );
  });

  $(function() {
$( "#datepicker" ).datepicker( "option", "dayNamesMin", [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ] );
  });

  $(function() {
$( "#datepicker" ).datepicker( "option", "firstDay", 1 );
  });

  $(function() {
$( "#datepicker" ).datepicker( "option", "autoSize", true );
  });