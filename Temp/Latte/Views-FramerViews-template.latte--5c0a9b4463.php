<?php
// source: /Users/macbookpro/gitrepos/framer-v2/Views/FramerViews/template.latte

use Latte\Runtime as LR;

final class Template5c0a9b4463 extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		['content' => 'blockContent'],
	];


	public function main(): array
	{
		extract($this->params);
		echo "\n";
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		$this->parentName = "Layouts/layout.latte";
		
	}


	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		echo '<h1>Hello ';
		echo LR\Filters::escapeHtmlText($name) /* line 4 */;
		echo ' !</h1>
';
	}

}
