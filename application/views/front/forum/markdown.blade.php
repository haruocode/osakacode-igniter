<style>
        .Comment .Media__body pre {
            margin: 0;
            background: none;
            line-height: 1.5em;
        }

        hr {
            margin: 20px 0;
            height: 0;
            border: none;
            /*border-top: 1px solid #ccc;*/
            /*border-bottom: 1px solid #eee;*/
        }

        .CodeMirror-scroll {
            /*padding: 40px !important;*/
            font-size: 16px;
            line-height: 1.5em;
            /*border: 1px solid #e0e0e0;*/
            background: #fff;
        }
        #preview {
            font-family: "Courier New";
            max-height: 400px;
            overflow-y: auto;
            font-size: 14px;
            padding: 10px !important;
            line-height: 1.5em;
            border: 1px solid #e0e0e0;
            background: #fff;
        }
        #preview pre {
            border: 1px solid #ccc;
            padding: 0.5em 1em;
            border-radius: 3px;
            background: #f0f0f0;
            margin-bottom: 1em;
        }
        #preview code {
            padding: 0 2px;
            background: #f2f2f2;
            word-wrap: break-word;
            font-size: 1em;
        }
</style>
<script src="{{asset('libraries/markdown-editor/markdown-it.js')}}"></script>
<script src="{{asset('libraries/markdown-editor/markdown-it-footnote.js')}}"></script>
<script src="{{asset('libraries/markdown-editor/highlight.pack.js')}}"></script>
<script src="{{asset('libraries/markdown-editor/emojify.js')}}"></script>
<link href="{{asset('libraries/atwho/css/jquery.atwho.css')}}" rel="stylesheet">
<script src="{{asset('libraries/atwho/js/jquery.caret.js')}}"></script>
<script src="{{asset('libraries/atwho/js/jquery.atwho.js')}}"></script>
<script>
    // Because highlight.js is a bit awkward at times
    var languageOverrides = {
        js: 'javascript',
        html: 'xml'
    };

    emojify.setConfig({img_dir: 'emoji'});

    var md = markdownit({
        highlight: function (code, lang) {
            if (languageOverrides[lang]) lang = languageOverrides[lang];
            if (lang && hljs.getLanguage(lang)) {
                try {
                    return hljs.highlight(lang, code).value;
                } catch (e) {
                }
            }
            return '';
        }
    }).use(markdownitFootnote);


    function updateMarkdown(value) {
        setOutput(value);
    }

    function setOutput(val) {
        val = val.replace(/<equation>((.*?\n)*?.*?)<\/equation>/ig, function (a, b) {
            return '<img src="http://latex.codecogs.com/png.latex?' + encodeURIComponent(b) + '" />';
        });

        var out = document.getElementById("{{$preview}}");
        var old = out.cloneNode(true);
        out.innerHTML = md.render(val);
        emojify.run(out);

        var allold = old.getElementsByTagName("*");
        if (allold === undefined) return;

        var allnew = out.getElementsByTagName("*");
        if (allnew === undefined) return;

        for (var i = 0, max = Math.min(allold.length, allnew.length); i < max; i++) {
            if (!allold[i].isEqualNode(allnew[i])) {
                out.scrollTop = allnew[i].offsetTop;
                return;
            }
        }
    }

    var editor = $('#{{$markdown}}');
    editor.on('keyup', function(){
        updateMarkdown($(this).val());
    }).on('keydown', function(e){
        enableTabTextarea($(this),e);
    });
    editor.atwho({
        at: '@',
        callbacks: {
            remoteFilter: function(query, callback){
                if(query.length < 3) {
                    return false;
                }
                $.ajax({
                    url : '{{Api\UrlGenerate\url_get_user()}}',
                    data : {q : query},
                    dataType : 'json',
                    success: function(data) {
                        callback(data);
                    }
                })
            }
        },
        limit: 5
    })
</script>
