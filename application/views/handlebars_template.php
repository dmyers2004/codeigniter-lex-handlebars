{{! Parsed: Hello, World! }}
Hello, {{ name }}!

{{! Parsed: <h1>Handlebars is Awesome!</h1> }}
<h1>{{ title }}</h1>

{{! Parsed: My real name is Lex Luther!</h1> }}
My real name is {{ real_name.first }} {{ real_name.last }}
<p>{{handle-plugin foo="bar" name="John Doe"}}</p>
<p>{{#handle-switch mode="uppercase"}}John Doe{{/handle-switch}}</p>
<p>{{#handle-switch mode="lowercase"}}John Doe{{/handle-switch}}</p>