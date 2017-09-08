/**
 * @copyright Mohammed Ibrahem. 2017
 * ebnibrahem@gmail.com.
 *
 */

/**
 * Clean text from html tags.
 * @param  {text} text
 * @return paint text
 */
 function strip_tags(text){
 	var regex = /(<([^>]+)>)/ig
 	var body = text;
 	var result = body.replace(regex, "");
 	return result;
 }
