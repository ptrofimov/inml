<?php

class Tokenizer
{
	const T_WORD = 'word';
	const T_SPACE = 'space';
	const T_EOL = 'eol';

	private $token=null;
	private $buffer='';
	private $tokens=[];

	public function process($text)
	{
		for ($i=0,$il=strlen($text);$i<$il;$i++){
			if (in_array($text[$i],[' ', "\t"])){
				$this->pushSymbol($text[$i],self::T_SPACE);
			}elseif(in_array($text[$i],["\n", "\r"])){
				$this->pushSymbol($text[$i],self::T_EOL);
			}else{
				$this->pushSymbol($text[$i],self::T_WORD);
			}
		}
		$this->pushSymbol(null,null);
		return $this->tokens;
	}

	private function pushSymbol($symbol,$token)
	{
		if(!is_null($this->token)&&$this->token!=$token||$symbol===null){
			$item=['token'=>$this->token
            ,'content'=>$this->buffer];
            if($item['token']==self::T_EOL){
                $content=$item['content'];
                $content=str_replace("\r\n","\n",$content);
                $content=str_replace("\r","\n",$content);
                $item['is_paragraph']=strlen($content)>1?true:false;
            }
            if($item['token']==self::T_WORD){
                $content=$item['content'];
                $item['is_class']=($content[0]=='.');
                $item['class']=$item['is_class']?substr($content,1):'';
            }

			$this->buffer='';
            $this->tokens[]=$item;
		}
		$this->token=$token;
		$this->buffer.=$symbol;
	}
}

/*class Processor
{
	private $in, $out;

	public function process($text)
	{
		//$lines = explode(PHP_EOL, $text);
		//$new = array_replace($lines, array(''), array('</p><p>'));
		//$out = implode(PHP_EOL, $new);
		$out = preg_replace('/('.PHP_EOL.')+/', '</p><p>', $text);
		$out = preg_replace('/(\S+)\.(\w+)/', '<span class="$2">$1</span>', $out);
		$out = preg_replace('/<p>.*\.(\w+)<\/p>/', '<div class="$2">$1</div>', $out);

		return '<p>'.$out.'</p>';
	}
}*/

$text = <<<TEXT
paragraph with no classes

.class1
paragraph with class

.class2 line with class
line with class .class2

line with word.class4 with class
TEXT;

/*$tokens = (new Tokenizer)->process($text);
var_dump($tokens);

if($tokens[0]['token']=='word'&&$tokens[0]['is_class']){
    $class=$tokens[0]['class'];
    echo "<p class='$class'>".PHP_EOL;
    $tokens=array_slice($tokens,1);
}else{
    echo '<p>'.PHP_EOL;
}
for($i=0,$il=count($tokens);$i<$il;$i++){
    $token=$tokens[$i];
    if($token['token']=='eol'&&$token['is_paragraph']){
        echo PHP_EOL.'</p>'.PHP_EOL.'<p>'.PHP_EOL;
        continue;
    }
    echo $token['content'];
}
echo PHP_EOL.'</p>'.PHP_EOL;*/

$text=preg_replace('/[ \t]+/', ' ', $text);
$text=str_replace("\r\n","\n",$text);
$text=str_replace("\r","\n",$text);
$text=preg_replace('/[\n]{2,}/', "\n\n", $text);

$paragraphs=explode("\n\n",$text);
foreach($paragraphs as &$item){
    $lines=explode("\n",$item);
    foreach($lines as &$item2){
        $item2=explode(' ', $item2);
    }
    $item=$lines;
}
unset($item);
var_dump($paragraphs);

foreach($paragraphs as $item){
    if(count($item[0])==1&&$item[0][0][0]=='.'){
        $class=substr($item[0][0],1);
        echo "<p class='$class'>";
    }else echo '<p>';

    foreach($item as &$item2){
        if($item2[0][0]=='.'){
            $class=substr($item2[0],1);
            array_shift($item2);
            $item2="<span class='$class'>".implode(' ',$item2).'</span>';
        }elseif($item2[count($item2)-1][0]=='.'){
            $class=substr($item2[count($item2)-1],1);
            array_pop($item2);
            $item2="<span class='$class'>".implode(' ',$item2).'</span>';
        }else{
            $item2=implode(' ',$item2);
        }
    }
    unset($item2);

    echo implode(' ',$item);

    echo '</p>';
}


// several .bold words.b in sentence

/*

some .words in sentence are bold.b

some.b words

.b sentence where all the words are bold
the same sentence .b

.bold sentence
.h1 header

.ul
.li sdf



.h1 Skazka o care saltane

Jil byl saltan


*/


