<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"         => ":attribute jābūt akceptētam.",
	"active_url"       => ":attribute nav derīga tīmekļa adrese.",
	"after"            => ":attribute jābūt datumam pēc :date.",
	"alpha"            => ":attribute drīkst saturēt vienīgi burtus.",
	"alpha_dash"       => ":attribute drīkst saturēt vienīgi burtus, numurus, un domuzīmes.",
	"alpha_num"        => ":attribute drīkst saturēt vienīgi burtus un numurus.",
	"array"            => ":attribute jābūt masīvam.",
	"before"           => ":attribute jābūt datumam pirms :date.",
	"between"          => array(
		"numeric" => ":attribute jābūt starp :min un :max.",
		"file"    => ":attribute jābūt starp :min un :max kilobaitiem.",
		"string"  => ":attribute jābūt starp :min un :max simboliem.",
		"array"   => ":attribute jābūt starp :min un :max vienumiem.",
	),
	"confirmed"        => ":attribute apstiprinājums nesakrīt.",
	"date"             => ":attribute nav korekts datums.",
	"date_format"      => ":attribute neatbilst formātam :format.",
	"different"        => ":attribute un :other jābūt dažādiem.",
	"digits"           => ":attribute jābūt :digits cipariem.",
	"digits_between"   => ":attribute jābūt starp :min un :max cipariem.",
	"email"            => ":attribute formāts nav derīgs.",
	"exists"           => "izvēlētais :attribute nav derīgs.",
	"image"            => ":attribute jābūt bildei.",
	"in"               => "izvēlētais :attribute nav derīgs.",
	"integer"          => ":attribute jābūt veselam skaitlim.",
	"ip"               => ":attribute jābūt derīgai IP addresei.",
	"max"              => array(
		"numeric" => ":attribute nedrīkst būt lielāks par :max.",
		"file"    => ":attribute nedrīkst būt lielāks par :max kilobaitiem.",
		"string"  => "Lauks ':attribute' nedrīkst būt lielāks par :max simboliem.",
		"array"   => ":attribute nedrīkst būt lielāks par :max vienumiem.",
	),
	"mimes"            => ":attribute jābūt failam ar vienu no tipiem: :values.",
	"min"              => array(
		"numeric" => ":attribute jābūt vismaz :min.",
		"file"    => ":attribute jābūt vismaz :min kilobaitiem.",
		"string"  => "Laukam ':attribute' jābūt vismaz :min simbolus garam.",
		"array"   => ":attribute jābūt vismaz :min vienumiem.",
	),
	"not_in"           => "izvēlētais :attribute nav derīgs.",
	"numeric"          => ":attribute jābūt numuram.",
	"regex"            => ":attribute formāts nav derīgs.",
	"required"         => "lauks ':attribute' ir nepieciešams.",
	"required_if"      => ":attribute lauks ir nepieciešams, kad :other ir :value.",
	"required_with"    => ":attribute lauks ir nepieciešams, kad :values ir klātesošs.",
	"required_without" => ":attribute lauks ir nepieciešams, kad :values nav klātesošs.",
	"same"             => ":attribute un :other ir jāsakrīt.",
	"size"             => array(
		"numeric" => ":attribute jābūt :size.",
		"file"    => ":attribute jābūt :size kilobaitiem.",
		"string"  => ":attribute jābūt :size simboliem.",
		"array"   => ":attribute jāsatur :size vienumus.",
	),
	"unique"           => ":attribute jau ir izvēlēts.",
	"url"              => ":attribute formāts nav derīgs.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/
    
	'attributes' => array(
            
            "phone" => "telefons",
            "username" => "lietotājvārds",
            "password" => "parole",
            "letter" => "vēstule",
            "checkbox" => "apstiprinājums",
            "email" => "E-pasts",
            "subject" => "tēma",
            "message" => "ziņa",
            "intro" => "ievads",
            "text" => "teksts",
            "name" => "nosaukums",
            "company" => "firma",
            "poster" => "afiša",
            "new_password" => "jaunā parole",
            "new_password_confirmation" => "jaunās paroles apstiprinājums",
            "firstname" => "vārds",
            "lastname" => "uzvārds",
            "userGroup" => "lietotāja grupa",
            "userType" => "lietotāja grupa",
            "about" => "par",
            "picture" => "bilde",
            "remember" => "atcerēties",
            "password_confirmation" => "paroles apstiprinājums",
            
        ),

);
