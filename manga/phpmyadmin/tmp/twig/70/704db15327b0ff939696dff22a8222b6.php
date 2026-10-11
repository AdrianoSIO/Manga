<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* table/browse_foreigners/show_all.twig */
class __TwigTemplate_7d759d72de06aa9e3c45f49fbedc7b75 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        if ((is_iterable(CoreExtension::getAttribute($this->env, $this->source, ($context["foreign_data"] ?? null), "disp_row", [], "any", false, false, false, 1)) && (        // line 2
($context["show_all"] ?? null) && (CoreExtension::getAttribute($this->env, $this->source, ($context["foreign_data"] ?? null), "the_total", [], "any", false, false, false, 2) > ($context["max_rows"] ?? null))))) {
            // line 3
            yield "    <input class=\"btn btn-secondary\" type=\"submit\" id=\"foreign_showAll\" name=\"foreign_showAll\" value=\"";
yield _gettext("Show all");
            // line 4
            yield "\">
";
        }
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "table/browse_foreigners/show_all.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  44 => 4,  41 => 3,  39 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "table/browse_foreigners/show_all.twig", "/workspaces/Manga/manga/phpmyadmin/templates/table/browse_foreigners/show_all.twig");
    }
}
