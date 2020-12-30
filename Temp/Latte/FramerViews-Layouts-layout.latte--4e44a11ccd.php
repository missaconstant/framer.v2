<?php
// source: /Users/macbookpro/gitrepos/framer-v2/Views/FramerViews/Layouts/layout.latte

use Latte\Runtime as LR;

final class Template4e44a11ccd extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		['content' => 'blockContent'],
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
        body {
            background: #222;
        }
    </style>
</head>
<body>

    ';
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('content', get_defined_vars());
		echo '

</body>
</html>';
		return get_defined_vars();
	}


	public function blockContent(array $ʟ_args): void
	{
		
	}

}
