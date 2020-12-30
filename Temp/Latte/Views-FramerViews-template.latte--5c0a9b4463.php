<?php
// source: /Users/macbookpro/gitrepos/framer-v2/Views/FramerViews/template.latte

use Latte\Runtime as LR;

final class Template5c0a9b4463 extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		['childstyle' => 'blockChildstyle', 'content' => 'blockContent'],
	];


	public function main(): array
	{
		extract($this->params);
		echo '

';
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('childstyle', get_defined_vars());
		echo '


';
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		$this->parentName = "Layouts/layout.latte";
		
	}


	public function blockChildstyle(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		echo '<style>
    h1 { margin:0; }
    .wrapper { position: absolute; top:0; left:0; right:0; bottom:0; display:flex; justify-content:center; align-items:center }
    .wrapper h1 { padding: 30px; border: 2px solid #fff; color: #fff; background: rgba(0,0,0,0.2) }
</style>
';
	}


	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		echo '<div class="wrapper">
    <h1>HELLO ';
		echo LR\Filters::escapeHtmlText(($this->filters->upper)($name)) /* line 15 */;
		echo ' !</h1>
</div>
';
	}

}
