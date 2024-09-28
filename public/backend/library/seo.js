(function($) {
	"use strict";
	var HT = {}; 

    HT.seoPreview = () => {
        $('input[name=meta_title]').on('keyup', function(){
            let input = $(this)
            let value = input.val()
            $('.meta-title').html(value)
        })


       $('.seo-canonical').each(function(){
            let _this = $(this)
            _this.css({
                'padding-left':   parseInt($('.baseUrl').outerWidth()) + 10
            })
       })

       $('input[name=canonical]').on('keyup', function(){
            let input = $(this)
            let value = HT.removeUtf8(input.val())
            $('.canonical').html(BASE_URL + value + SUFFIX) 
        })

       


        $(document).on('keyup', '.change-title', function(e){
            let _this = $(this)
            let flag = _this.attr('data-flag')
            let canonical = HT.removeUtf8(_this.val())
            if(flag == 0){
                $('.seo-canonical').val(canonical).trigger('keyup')
            }
        })
    }

    HT.checkSeoDescriptionLength = () => {
        $('textarea[name=meta_description]').on('keyup change', function(){
            let input = $(this)
            let value = input.val()
            $('.countD').html(value.length)
            $('.meta-description').html(value)
            if(value.length > 160){
                input.css({
                    'border': '1px solid red'
                })
                $('.countD').css({
                    'color': 'red'
                })
            }else{
                input.css({
                    'border': '1px solid #c4cdd5'
                })
                $('.countD').css({
                    'color': '#676a6c'
                })
            }

        })
    }

    
    
    HT.searchTags = () => {
        $('#tagSearch').select2();
    
        let typingTimer; 
        let existingIds = new Set(); 
    
        $('#tagSearch').on('select2:open', function() {
            let searchField = $('.select2-search__field');
    
            searchField.off('keyup').on('keyup', function() {
                let keyword = $(this).val().trim();
    
                if (keyword.length < 2) {
                    return; 
                }
    
                clearTimeout(typingTimer);
    
                typingTimer = setTimeout(function() {
                    $.ajax({
                        url: 'ajax/post/findTag',
                        type: 'GET',
                        data: {
                            name: keyword,
                            model: 'Tag'
                        },
                        dataType: 'json',
                        success: function(res) {

                            const options = res.map(item => {

                                return { id: item.id, text: item.name };

                            });

                            let $select = $('#tagSearch');

                            let selectedIds = new Set($select.val());

                            options.forEach(option => {
                                if (!selectedIds.has(option.id) && !$select.find(`option[value="${option.id}"]`).length) {
                                    let newOption = new Option(option.text, option.id, false, false);
                                    $select.append(newOption);
                                }
                            });
                            
                            $select.val([...selectedIds]).trigger('change');

                            
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching tags:', error);
                        }
                    });
                }, 100); 
            });
        });
    };
    


    HT.removeUtf8 = (str) => {
        str = str.toLowerCase(); // chuyen ve ki tu biet thuong
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|,|\.|\:|\;|\'|\–| |\"|\&|\#|\[|\]|\\|\/|~|$|_/g, "-");
        str = str.replace(/-+-/g, "-");
        str = str.replace(/^\-+|\-+$/g, "");
        return str;
    }

	$(document).ready(function(){
        HT.searchTags()
        HT.seoPreview()
        HT.checkSeoDescriptionLength()
	});

    

})(jQuery);
