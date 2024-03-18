

export  function test () {
        console.log(222);
}

export  function GetYears () {
  const current_year = new Date().getFullYear();
  const start_year = 1990;
  const years = [] ;
  for (let year = current_year; year >= start_year; year--) {
      years.push(year);
  }
  return years ;
}

export function  MakeNumberLikeMony (number) {
  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")  ;
      // form.reserve =  number.value.replace(/,/g, '');
}

export function Back() {
  window.history.back() ;
}


// disable previes Date
export  function DisablePreviesDate(from_date_element , to_date_element   ) {
                 var dtToday = new Date();
                 var month = dtToday.getMonth() + 1;     // getMonth() is zero-based
                 var day = dtToday.getDate();
                 var year = dtToday.getFullYear();
                 let hour = dtToday.getHours();
                 let minutes = dtToday.getMinutes();
                 let seconds = dtToday.getSeconds();
         
                 if(month < 10)
                   month = '0' + month.toString();
                 if(day < 10)
                   day = '0' + day.toString();
                 if(hour < 10)
                 hour = '0' + hour.toString();
                 if(minutes < 10)
                 minutes = '0' + minutes.toString();
                 if(seconds < 10)
                 seconds = '0' + seconds.toString();
         
                 var min_date = year + '-' + month + '-' + day+' '+hour+":"+minutes;
            
                 from_date_element.setAttribute('min',min_date);
                 to_date_element.setAttribute('min',min_date);
}
//  get date object and format that date 2023-07-18 20:13
export  function DateFormat( DateValue ) {
    DateValue = new Date(DateValue);
  var month = DateValue.getMonth() + 1;     // getMonth() is zero-based
  var day = DateValue.getDate();
  var year = DateValue.getFullYear();
  let hour = DateValue.getHours();
  let minutes = DateValue.getMinutes();
  let seconds = DateValue.getSeconds();

  if(month < 10)
    month = '0' + month.toString();
  if(day < 10)
    day = '0' + day.toString();
  if(hour < 10)
  hour = '0' + hour.toString();
  if(minutes < 10)
  minutes = '0' + minutes.toString();
  if(seconds < 10)
  seconds = '0' + seconds.toString();

  var DateValue  = year + '-' + month + '-' + day+' '+hour+":"+minutes;

  return DateValue ;
}


export function  CheckEndDate (end_date ) {
  const now = new Date() ;
  const end = new Date(end_date);
  var diffTime  = Math.max(end - now, 0); // ensure non-negative value

  if (diffTime <= 0) {
    return  true ;
  } else {
   return false ;
  }

}

export function   GetRatingPercentage( ratings_total , rating_count ) {
  if (ratings_total  > 0 ) {
    return   (( rating_count / ratings_total    ) * 100).toFixed(2)   ; 
  }
  return 0 ;
}

export function   GetFileExtention( file_name ) {
  return  file_name.split('.').pop() ;
}


export function IsImageOrPdf(file_path) {
  const image_extensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp'];
  const pdf_extension = '.pdf';
 
  const extension = file_path.substring(file_path.lastIndexOf('.')).toLowerCase();
 

  return image_extensions.includes(extension) ? 'image' :
                  extension === pdf_extension ? 'pdf' :
                  'unknown';
}
