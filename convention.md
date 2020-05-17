#Base
##Naming
- Use lowerCamelCase when naming functions or variables.
```
function doSomething( $userPrefs, $editSummary )
```
- Use UpperCamelCase when naming classes: class `ImportantClass`.
- Always declare method of class is `public`, `protected` or `private`.
- Private or protected method should start with underscore : 
`private function _getSomething()`.
- Method for get data start with `get`, for set data start with `set`
```
public function getPermission();
private function setName();
```
- Method for pre process data should be start with `parse`
```
public function parseDateTimeToString()
```
- Class file should be naming like class name
```
file: MyClass.php
class MyClass {
}
```
- function helper file should naming with `filename_helper.php`
- view file must end with `.blade.php`
- for render from controller to view, must render with array `dataView` 

##Code style
###Controller
- With `POST` request, controller method `must` start with `post`
```
public function postPost();
public function postComment();
```
- With `GET` request, controller method `should` start with `get`
```
public function getDetailPost();
public function getDetailComment();
```
- With `AJAX` request, controller method `must` start with `ajax`, and `should` return json string of `arrayReturn`. Should declare variable `$arrayReturn` in the first line of method
```
public function ajaxLikePost() {
	$arrayReturn = [];
	...
	echo json_encode($arrayReturn);
	die();
}
```
- Comment:
	- With comment in one line, should use `//this is a comment` or `#this is another comment`, not use `/** this is a bad comment **/`
	- Comment for declare function should use
```
	/**
	* @var String $param1: Description for param1
	* @var Array $param2: Description for param2
	* @return Type
    **/
	function myFn($param1, $param2)  {}
```
- Don't use `@` for suppress error through any reason. Best practice is use exception if you can.
```
// bad using
@copy("filename");
// best practice
$checkExist = file_exists("filename");
if($checkExist) {
	try {
		copy("filename");
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage();
	}
}
```