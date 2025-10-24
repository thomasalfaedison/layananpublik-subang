<?php


namespace LaravelHtml\Html\Facades;


use Illuminate\Support\Facades\Facade;
use LaravelHtml\Html\Tag;

/**
 * Class HtmlFacade
 * @package App\Metronic\Facades
 * @method static Tag a(array $attributes = [])
 * @method static Tag abbr(array $attributes = [])
 * @method static Tag acronym(array $attributes = [])
 * @method static Tag address(array $attributes = [])
 * @method static Tag applet(array $attributes = [])
 * @method static Tag area(array $attributes = [])
 * @method static Tag article(array $attributes = [])
 * @method static Tag aside(array $attributes = [])
 * @method static Tag audio(array $attributes = [])
 *
 * @method static Tag b(array $attributes = [])
 * @method static Tag basefont(array $attributes = [])
 * @method static Tag bdi(array $attributes = [])
 * @method static Tag bdo(array $attributes = [])
 * @method static Tag bgsound(array $attributes = [])
 * @method static Tag blockquote(array $attributes = [])
 * @method static Tag big(array $attributes = [])
 * @method static Tag body(array $attributes = [])
 * @method static Tag blink(array $attributes = [])
 * @method static Tag br(array $attributes = [])
 * @method static Tag button(array $attributes = [])
 *
 * @method static Tag canvas(array $attributes = [])
 * @method static Tag caption(array $attributes = [])
 * @method static Tag center(array $attributes = [])
 * @method static Tag cite(array $attributes = [])
 * @method static Tag code(array $attributes = [])
 * @method static Tag col(array $attributes = [])
 * @method static Tag colgroup(array $attributes = [])
 * @method static Tag command(array $attributes = [])
 *
 * @method static Tag datalist(array $attributes = [])
 * @method static Tag dd(array $attributes = [])
 * @method static Tag del(array $attributes = [])
 * @method static Tag details(array $attributes = [])
 * @method static Tag dfn(array $attributes = [])
 * @method static Tag dir(array $attributes = [])
 * @method static Tag div(array $attributes = [])
 * @method static Tag dl(array $attributes = [])
 * @method static Tag dt(array $attributes = [])
 *
 * @method static Tag em(array $attributes = [])
 * @method static Tag embed(array $attributes = [])
 *
 * @method static Tag fieldset(array $attributes = [])
 * @method static Tag figcaption(array $attributes = [])
 * @method static Tag figure(array $attributes = [])
 * @method static Tag font(array $attributes = [])
 * @method static Tag form(array $attributes = [])
 * @method static Tag footer(array $attributes = [])
 * @method static Tag frame(array $attributes = [])
 * @method static Tag frameset(array $attributes = [])
 *
 * @method static Tag h1(array $attributes = [])
 * @method static Tag h2(array $attributes = [])
 * @method static Tag h3(array $attributes = [])
 * @method static Tag h4(array $attributes = [])
 * @method static Tag h5(array $attributes = [])
 * @method static Tag h6(array $attributes = [])
 * @method static Tag head(array $attributes = [])
 * @method static Tag header(array $attributes = [])
 * @method static Tag hgroup(array $attributes = [])
 * @method static Tag hr(array $attributes = [])
 * @method static Tag html(array $attributes = [])
 *
 * @method static Tag i(array $attributes = [])
 * @method static Tag iframe(array $attributes = [])
 * @method static Tag img(array $attributes = [])
 * @method static Tag input(array $attributes = [])
 * @method static Tag ins(array $attributes = [])
 * @method static Tag isindex(array $attributes = [])
 *
 * @method static Tag kbd(array $attributes = [])
 * @method static Tag keygen(array $attributes = [])
 *
 * @method static Tag label(array $attributes = [])
 * @method static Tag legend(array $attributes = [])
 * @method static Tag li(array $attributes = [])
 * @method static Tag link(array $attributes = [])
 *
 * @method static Tag main(array $attributes = [])
 * @method static Tag map(array $attributes = [])
 * @method static Tag marquee(array $attributes = [])
 * @method static Tag mark(array $attributes = [])
 * @method static Tag menu(array $attributes = [])
 * @method static Tag meta(array $attributes = [])
 * @method static Tag meter(array $attributes = [])
 *
 * @method static Tag nav(array $attributes = [])
 * @method static Tag nobr(array $attributes = [])
 * @method static Tag noembed(array $attributes = [])
 * @method static Tag noframes(array $attributes = [])
 * @method static Tag noscript(array $attributes = [])
 *
 * @method static Tag object(array $attributes = [])
 * @method static Tag ol(array $attributes = [])
 * @method static Tag optgroup(array $attributes = [])
 * @method static Tag option(array $attributes = [])
 * @method static Tag output(array $attributes = [])
 *
 * @method static Tag p(array $attributes = [])
 * @method static Tag param(array $attributes = [])
 * @method static Tag plaintext(array $attributes = [])
 * @method static Tag pre(array $attributes = [])
 * @method static Tag progress(array $attributes = [])
 *
 * @method static Tag q(array $attributes = [])
 *
 * @method static Tag s(array $attributes = [])
 * @method static Tag select(array $attributes = [])
 * @method static Tag strike(array $attributes = [])
 * @method static Tag summary(array $attributes = [])
 * @method static Tag samp(array $attributes = [])
 * @method static Tag small(array $attributes = [])
 * @method static Tag strong(array $attributes = [])
 * @method static Tag sup(array $attributes = [])
 * @method static Tag script(array $attributes = [])
 * @method static Tag span(array $attributes = [])
 * @method static Tag style(array $attributes = [])
 * @method static Tag section(array $attributes = [])
 * @method static Tag source(array $attributes = [])
 * @method static Tag sub(array $attributes = [])
 *
 * @method static Tag table(array $attributes = [])
 * @method static Tag tbody(array $attributes = [])
 * @method static Tag td(array $attributes = [])
 * @method static Tag textarea(array $attributes = [])
 * @method static Tag tfoot(array $attributes = [])
 * @method static Tag th(array $attributes = [])
 * @method static Tag thead(array $attributes = [])
 * @method static Tag time(array $attributes = [])
 * @method static Tag title(array $attributes = [])
 * @method static Tag tr(array $attributes = [])
 * @method static Tag tt(array $attributes = [])
 *
 * @method static Tag u(array $attributes = [])
 * @method static Tag ul(array $attributes = [])
 *
 * @method static Tag var(array $attributes = [])
 * @method static Tag video(array $attributes = [])
 *
 * @method static Tag wbr(array $attributes = [])
 *
 * @method static Tag xmp(array $attributes = [])
 *
 */
class Html extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'infureal_html';
    }

}
