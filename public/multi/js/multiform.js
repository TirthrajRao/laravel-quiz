(function ( $ ) {
  $.fn.multiStepForm = function(args) {
    if(args === null || typeof args !== 'object' || $.isArray(args))
      throw  " : Called with Invalid argument";
    var form = this;
    var tabs = form.find('.tab');
    var steps = form.find('.step');
    steps.each(function(i, e){
      $(e).on('click', function(ev){
        form.navigateTo(i);
      });
    });
    form.navigateTo = function (i) {/*index*/
      /*Mark the current section with the class 'current'*/
      tabs.removeClass('current').eq(i).addClass('current');
        // Show only the navigation buttons that make sense for the current section:
        form.find('.previous').toggle(i > 0);
        atTheEnd = i >= tabs.length - 1;
        form.find('.next').toggle(!atTheEnd);
        // console.log('atTheEnd='+atTheEnd);
        form.find('.submit').toggle(atTheEnd);
        fixStepIndicator(curIndex());
        return form;
      }
      function curIndex() {
        /*Return the current index by looking at which section has the class 'current'*/
        return tabs.index(tabs.filter('.current'));
      }
      function fixStepIndicator(n) {
        steps.each(function(i, e){
          i == n ? $(e).addClass('active') : $(e).removeClass('active');
        });
      }
      /* Previous button is easy, just go back */
      form.find('.previous').click(function() {
        form.navigateTo(curIndex() - 1);
      });

      /* Next button goes forward iff current block validates */
      form.find('.next').click(function() {
        if('validations' in args && typeof args.validations === 'object' && !$.isArray(args.validations)){
          if(!('noValidate' in args) || (typeof args.noValidate === 'boolean' && !args.noValidate)){
            form.validate(args.validations);
            if(form.valid() == true){
              form.navigateTo(curIndex() + 1);
              // startTimer();
              return true;
            }
            return false;
          }
        }
        form.navigateTo(curIndex() + 1);
      });
      /*By default navigate to the tab 0, if it is being set using defaultStep property*/
      typeof args.defaultStep === 'number' ? form.navigateTo(args.defaultStep) : null;

      form.noValidate = function() {

      }
      return form;
    };
  }( jQuery ));