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

/* table/browse_foreigners/column_element.twig */
class __TwigTemplate_e81a0c7520a07d8836d85927d4cd3720 extends Template
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
        yield "<td";
        yield ((($context["nowrap"] ?? null)) ? (" class=\"text-nowrap\"") : (""));
        yield ">
    ";
        // line 2
        yield ((($context["is_selected"] ?? null)) ? ("<strong>") : (""));
        yield "
        <a class=\"foreign_value\" data-key=\"";
        // line 3
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["keyname"] ?? null), "html", null, true);
        yield "\" href=\"#\" title=\"";
yield _gettext("Use this value");
        // line 4
        (( !Twig\Extension\CoreExtension::testEmpty(($context["title"] ?? null))) ? (yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((": " . ($context["title"] ?? null)), "html", null, true)) : (yield ""));
        yield "\">
            ";
        // line 5
        if (($context["nowrap"] ?? null)) {
            // line 6
            yield "                ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["keyname"] ?? null), "html", null, true);
            yield "
            ";
        } else {
            // line 8
            yield "                ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["description"] ?? null), "html", null, true);
            yield "
            ";
        }
        // line 10
        yield "        </a>
    ";
        // line 11
        yield ((($context["is_selected"] ?? null)) ? ("</strong>") : (""));
        yield "
</td>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "table/browse_foreigners/column_element.twig";
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
        return array (  72 => 11,  69 => 10,  63 => 8,  57 => 6,  55 => 5,  51 => 4,  47 => 3,  43 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "table/browse_foreigners/column_element.twig", "/workspaces/Manga/manga/phpmyadmin/templates/table/browse_foreigners/column_element.twig");
    }
}
