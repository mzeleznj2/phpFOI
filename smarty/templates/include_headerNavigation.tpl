<header class="no-print">
    <figure>
        <figcaption id="naslov">{$title}</figcaption>
        <img id="naslovna" src="slike/logo.png" width="300" height="100" usemap="#mapa1" alt="logo">
    </figure>
</header>

        <nav id="meni" class="no-print">
    <ul>
        {$meni}
    </ul>
</nav>

{if !empty($greske) }
    <div id="greske">
        <ul>
            {foreach $greske as $greska}
                <li>{$greska}</li>
            {/foreach}
        </ul>
    </div>
{/if}

{if !empty($uspjehi) }
    <div id="uspjehi">
        <ul>
            {foreach $uspjehi as $uspjeh}
                <li>{$uspjeh}</li>
            {/foreach}
        </ul>
    </div>
{/if}