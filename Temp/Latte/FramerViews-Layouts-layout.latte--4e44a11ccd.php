<?php
// source: /Users/macbookpro/gitrepos/framer-v2/Views/FramerViews/Layouts/layout.latte

use Latte\Runtime as LR;

final class Template4e44a11ccd extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		['childstyle' => 'blockChildstyle', 'content' => 'blockContent'],
	];


	public function main(): array
	{
		extract($this->params);
		echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-image: url(\'';
		echo LR\Filters::escapeCss(assets("images/bg.jpg")) /* line 15 */;
		echo '\');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
    </style>

    ';
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('childstyle', get_defined_vars());
		echo '
</head>
<body>

    ';
		$this->renderBlock('content', get_defined_vars());
		echo '

</body>
</html>';
		return get_defined_vars();
	}


	public function blockChildstyle(array $ʟ_args): void
	{
		
	}


	public function blockContent(array $ʟ_args): void
	{
		
	}

}
