
var count=0;
$(document).on('click','#add-form-btn',function(){
    var lastRepeatingGroup = $('.vehicle-form').last();
   
   var dd= lastRepeatingGroup.clone().insertAfter(lastRepeatingGroup);
        // var $originalSelect = $(lastRepeatingGroup).find('.selectpicker');
        // $originalSelect.next().addClass('d-none')
        // $originalSelect.selectpicker('refresh');
        $(dd).find('input').val(' ')
        $(dd).find('textarea').text(' ')
        $(dd).find('select option:selected').removeAttr('selected');
        $('.select2-container').remove();
        $('.filter-form').select2({
          placeholder: "Placeholder text",
          allowClear: true,
          multiple:true
        });
        $('.select2-container').css('width','100%');
        $(dd).find('#escort_id').attr('name', `escort_id[${count+1}][]`)
       
        reorderForms()
     checkDeleteButtonVisibility();
     count++

})
$(document).ready(function(){
    // $(document).find('select').select2()
    $('.filter-form').select2({
        theme:'bootstrap4',
        placeholder: "Placeholder text",
        allowClear: true,
        multiple:true
    });
})


function createDive(){
   
    var lastRepeatingGroup = $('.card-order').last();
    lastRepeatingGroup.clone().insertAfter(lastRepeatingGroup);
        var $originalSelect = $(lastRepeatingGroup).find('.selectpicker');
        $originalSelect.next().addClass('d-none')
        $originalSelect.selectpicker('render');
        reorderForms1()
     checkDeleteButtonVisibility();
     count++
}

$(document).on('click', '.delete-form-btn', function () {
    $(this).closest('.vehicle-form').remove();
    reorderForms();
    checkDeleteButtonVisibility();
});

let order_number = $(document).find('.vehicle-form input.number:first').val();
function reorderForms() {
    // Reorder the number inputs after deletion
    let value = order_number;
    let number = Number( value.replace(/\D/g, '') );
    let perfix = value.replace(number, '');

   $.each($(document).find('.vehicle-form'), function() {
        $(this).find('.number').val(`${perfix}${number}`);
        number ++;
   });

}

let order_number1 = $(document).find('.card-order input.number:first').val();
function reorderForms1() {
    // Reorder the number inputs after deletion
    let value = order_number1;
    let number = Number( value.replace(/\D/g, '') );
    let perfix = value.replace(number, '');

   $.each($(document).find('.card-order'), function() {
        $(this).find('.number').val(`${perfix}${number}`);
        number ++;
   });

}
function checkDeleteButtonVisibility() {
    var formCount = $('.vehicle-form').length;
    $('.delete-form-btn').each(function () {
        if (formCount <= 1) {
            $(this).hide();
        } else {
            $(this).show();
        }
    });
}


$('body').on('click','#add',function(e){
    e.preventDefault()
    var lastRepeatingGroup = $('.card-order').last();
var after= lastRepeatingGroup.clone().insertAfter(lastRepeatingGroup);
$(after).find('input').not("#procedure_number").val('')
$(after).find('select option:selected').removeAttr('selected');
   
   reorderForms2()
count++
})

let order_number2 = $('#procedure_number:first').val();

function reorderForms2() {
// Reorder the number inputs after deletion
let value = order_number2;
let number = Number(value);
$.each($(document).find('.card-order'), function() {


    $(this).find('#procedure_number').val(`${number}`);
    number ++;
});

}

$('body').on('click','#remove',function(e){
e.preventDefault()
$(this).closest('.card-order').remove()
if($('body').find('.card-order').length == 0){
$('#card-order').css('disple','none')

}
reorderForms2()

})