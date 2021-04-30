$(document).ready(function(){
    tail.select('.boxing',{
        search: true,
        locale: "es",
        multiSelectAll: false,
        searchMinLength: 0,
        multiContainer: false,
    });
    tail.select('#agente',{
        search: true,
        locale: "es",
        multiSelectAll: true,
        searchMinLength: 0,
        multiContainer: false,
    });
    tail.select('.todos',{// clase para cualquier select multiselect
        search: true,
        locale: "es",
        multiSelectAll: true,
        searchMinLength: 0,
        multiContainer: false,
    });
    tail.select('#asignaAgente',{
        search: true,
        locale: "es",
        multiSelectAll: false,
        searchMinLength: 0,
        multiContainer: false,
    });
    tail.select('.razonSocialProfesor',{
        search: true,
        locale: "es",
        multiSelectAll: false,
        searchMinLength: 0,
        multiContainer: false,
    });
    tail.select('.todosUnique',{ // clase para cualquier select uni select
        search: true,
        locale: "es",
        multiSelectAll: false,
        searchMinLength: 0,
        multiContainer: false,
    });
       


});