<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{

    public function run(): void
    {
        Level::create([
            'name' => 'Primary Plus 1 (A1 - Principiante)',
            'description' => 'En este nivel, el estudiante está comenzando a aprender inglés. Puede entender y usar palabras y frases muy básicas relacionadas con temas familiares como la familia, la escuela, los animales, la comida y las rutinas diarias. Se comunica de forma muy simple, usando oraciones cortas y con apoyo visual o gestos.
El estudiante puede presentarse, hablar de cosas que le gustan o no, seguir instrucciones básicas en clase y leer o escribir textos muy breves. También empieza a formar preguntas y respuestas sencillas. Este nivel busca que el estudiante pierda el miedo a hablar en inglés y que disfrute aprendiendo a través de juegos, canciones, historias y actividades interactivas.',
            'aprobado' => 'El estudiante ha desarrollado habilidades básicas en inglés acordes con el nivel Primary Plus 1 (A1). Puede comunicarse usando frases sencillas sobre temas conocidos, comprende instrucciones básicas y participa activamente en actividades orales, de lectura y escritura propias de su nivel.',
            'desaprobado' => 'El estudiante aún no ha alcanzado completamente las habilidades esperadas para el nivel Primary Plus 1 (A1). Presenta dificultad para comunicarse en inglés usando frases básicas y requiere mayor apoyo para comprender instrucciones, participar oralmente y desarrollar tareas de lectura y escritura acordes con su nivel.',
            'level' => 1
        ]);
        Level::create([
            'name' => 'Primary Plus 2 (A1 – Alto)',
            'description' => 'En este nivel, el estudiante ya tiene una base del idioma inglés y puede usar el idioma con
más seguridad para hablar sobre sí mismo, su entorno y actividades cotidianas.
Comprende y produce frases completas, hace y responde preguntas sencillas, y participa
en conversaciones breves sobre temas conocidos.
También puede leer textos cortos y simples (como cuentos o descripciones) y escribir
oraciones o párrafos breves sobre temas familiares. Su vocabulario se amplía y empieza a
usar con más precisión algunas estructuras gramaticales básicas. El objetivo de este
nivel es ayudar al estudiante a comunicarse de forma más independiente y natural en
situaciones del día a día, usando el inglés con confianza.',
            'aprobado' => 'El estudiante ha demostrado un buen manejo de las habilidades correspondientes al
nivel Primary Plus 2 (A1 alto). Puede comunicarse en inglés usando frases completas,
comprende textos breves, responde preguntas sencillas y participa activamente en
actividades orales y escritas sobre temas conocidos.',
            'desaprobado' => 'El estudiante aún no ha alcanzado completamente las habilidades esperadas para el
nivel Primary Plus 2 (A1 alto). Presenta dificultades para comunicarse con frases
completas, comprender textos sencillos y participar activamente en actividades orales y
escritas. Se recomienda refuerzo y práctica adicional con la plataforma de Richmond
para consolidar los contenidos del nivel.',
            'level' => 2
        ]);
        Level::create([
            'name' => 'Primary Plus 3 (A2 Inicial)',
            'description' => 'En este nivel, el estudiante comienza a usar el inglés con mayor fluidez y seguridad.
Puede comunicarse sobre temas familiares de forma más natural y entender
conversaciones sencillas. Utiliza frases más completas y puede describir acciones,
personas, lugares y experiencias básicas con mayor detalle. El estudiante también puede
leer y comprender textos más largos y variados, como correos, historietas, descripciones
o diálogos. En escritura, ya es capaz de redactar párrafos simples con estructura clara,
usando conectores básicos como and, but, because. Este nivel busca que el estudiante
se exprese de forma más autónoma y que empiece a usar el inglés en contextos más
amplios y variados.',
            'aprobado' => 'El estudiante ha alcanzado satisfactoriamente los objetivos del nivel Primary Plus 3 (A2
inicial). Demuestra capacidad para comunicarse con mayor fluidez y seguridad,
comprendiendo textos sencillos y expresándose con oraciones completas y párrafos
cortos. Participa activamente en actividades orales y escritas sobre temas familiares y
cotidianos.',
            'desaprobado' => 'El estudiante aún no ha alcanzado los objetivos del nivel Primary Plus 3 (A2 inicial).
Presenta dificultades para expresarse en inglés con frases completas, comprender textos
sencillos y escribir párrafos organizados. Se recomienda reforzar el uso de estructuras
gramaticales básicas y ampliar el vocabulario para mejorar su desempeño general.',
            'level' => 3
        ]);
        Level::create([
            'name' => 'Primary Plus 4 (A2 – Medio)',
            'description' => 'En este nivel, el estudiante puede comunicarse con mayor confianza en inglés sobre
una variedad de temas personales y cotidianos. Es capaz de mantener conversaciones
simples, expresar opiniones, hacer sugerencias y contar experiencias pasadas de forma
más detallada. También puede leer textos más largos, como historias, artículos cortos o
correos electrónicos, y escribir párrafos organizados con ideas claras y conectores
adecuados. Empieza a desarrollar una mejor comprensión del uso de los tiempos
verbales y estructuras más complejas, como preguntas indirectas y conectores de causa
y consecuencia. El objetivo de este nivel es que el estudiante logre usar el inglés de
manera más independiente y precisa, preparándolo para situaciones comunicativas
más reales y variadas.',
            'aprobado' => 'El estudiante ha alcanzado los objetivos del nivel Primary Plus 4 (A2 medio). Se comunica
con mayor seguridad en inglés, participa activamente en conversaciones simples,
comprende textos más extensos y redacta párrafos organizados sobre temas cotidianos.
Demuestra un buen manejo del vocabulario y las estructuras gramaticales del nivel.',
            'desaprobado' => 'El estudiante aún no ha alcanzado los objetivos del nivel Primary Plus 4 (A2 medio).
Presenta dificultades para expresarse con claridad en inglés, comprender textos más
extensos y redactar párrafos organizados. Se recomienda fortalecer el uso de estructuras
gramaticales clave y ampliar el vocabulario mediante práctica adicional y
acompañamiento académico.',
            'level' => 4
        ]);
        Level::create([
            'name' => 'Primary Plus 5 (A2 – Alto)',
            'description' => 'En este nivel, el estudiante usa el inglés con mayor seguridad y fluidez en situaciones
comunes. Es capaz de comprender y producir textos más completos, expresar
opiniones, relatar experiencias pasadas, hablar sobre planes futuros y describir
situaciones con detalle. Se espera que el estudiante tenga una mayor precisión
gramatical y un vocabulario más amplio, y que pueda comunicarse con claridad tanto
de forma oral como escrita. Puede desenvolverse en conversaciones más complejas,
utilizando conectores y estructuras variadas para organizar sus ideas. Este nivel prepara
al estudiante para transitar hacia el nivel B1, donde se espera una comunicación más
autónoma en contextos más amplios.',
            'aprobado' => 'El estudiante ha alcanzado los objetivos del nivel Primary Plus 5 (A2 alto). Se comunica
con seguridad en inglés, comprendiendo y produciendo textos más desarrollados.
Participa activamente en conversaciones, expresa opiniones, relata experiencias y
escribe con organización y precisión. Demuestra un dominio sólido del vocabulario y las
estructuras gramaticales correspondientes al nivel.',
            'desaprobado' => 'El estudiante aún no ha alcanzado los objetivos del nivel Primary Plus 5 (A2 alto).
Presenta dificultades para expresarse con claridad en inglés, comprender textos más
extensos y redactar escritos organizados. Se recomienda reforzar el uso de estructuras
gramaticales clave, ampliar el vocabulario y continuar con la práctica oral y escrita para
consolidar su progreso.',
            'level' => 5
        ]);
        Level::create([
            'name' => 'Secondary Plus A1',
            'description' => 'En este nivel, el estudiante es capaz de comunicarse de forma básica en inglés en
situaciones cotidianas. Puede presentarse, hablar de sí mismo, su familia, su escuela
y sus intereses, usando frases cortas y estructuras simples.
El estudiante comprende instrucciones claras y textos muy sencillos, y puede
formular preguntas y dar respuestas básicas relacionadas con temas familiares.
También puede escribir oraciones simples y párrafos muy cortos usando vocabulario
común. Este nivel busca establecer una base sólida en comprensión y producción oral y
escrita, para que el estudiante pueda avanzar con confianza hacia niveles más altos.',
            'aprobado' => 'El estudiante ha alcanzado los objetivos del nivel Secondary Plus A1. Se comunica en
inglés utilizando frases simples para hablar sobre sí mismo, su entorno y temas
familiares. Comprende instrucciones claras, participa en conversaciones básicas y
redacta textos breves con vocabulario apropiado para su nivel.',
            'desaprobado' => 'El estudiante aún no ha alcanzado los objetivos del nivel Secondary Plus A1. Presenta
dificultades para expresarse en inglés con frases simples, comprender instrucciones
básicas y redactar textos breves. Se recomienda continuar reforzando el vocabulario y las
estructuras gramaticales fundamentales para mejorar su comprensión y producción oral
y escrita.',
            'level' => 6
        ]);

        Level::create([
            'name' => 'Secondary Plus A2',
            'description' => 'En este nivel, el estudiante puede comunicarse de forma sencilla pero eficaz en
situaciones comunes. Puede hablar sobre su vida diaria, gustos, rutinas, experiencias
pasadas y planes futuros usando frases completas y estructuras básicas. El estudiante
entiende textos breves y conversaciones claras, participa en intercambios simples de
información y es capaz de escribir párrafos cortos sobre temas familiares.
Este nivel permite al estudiante interactuar con más seguridad y empezar a usar el inglés
de manera más independiente, preparándolo para transitar hacia el nivel B1.',
            'aprobado' => 'El estudiante ha cumplido con los objetivos del nivel Secondary Plus A2. Demuestra
capacidad para comunicarse en inglés de manera sencilla y efectiva en situaciones
cotidianas. Participa activamente en conversaciones, comprende textos breves y redacta
párrafos claros sobre temas familiares.',
            'desaprobado' => 'El estudiante aún no ha alcanzado los objetivos del nivel Secondary Plus A2. Presenta
dificultades para comunicarse con claridad en situaciones cotidianas, comprender textos
breves y redactar párrafos coherentes. Se recomienda fortalecer el vocabulario, la
gramática y la práctica oral y escrita para mejorar su desempeño.',
            'level' => 7
        ]);
        Level::create([
            'name' => 'Secondary Plus B1 (B1)',
            'description' => 'En este nivel, el estudiante es capaz de comunicarse de manera clara y efectiva en una
variedad de situaciones cotidianas y algunas situaciones más complejas. Puede expresar
opiniones, justificar puntos de vista y narrar experiencias con mayor detalle.
El estudiante entiende la idea principal de textos complejos y conversaciones,
participa activamente en discusiones sobre temas familiares y es capaz de escribir textos
coherentes y bien estructurados, como cartas, informes o ensayos breves. Este nivel
marca el paso a una comunicación más autónoma e independiente, facilitando la
interacción en contextos académicos y sociales.',
            'aprobado' => 'El estudiante ha alcanzado con éxito los objetivos del nivel Secondary Plus B1. Se
comunica con fluidez y claridad en inglés, expresando opiniones, narrando experiencias y
participando en discusiones sobre temas variados. Demuestra una comprensión sólida
de textos complejos y escribe textos bien estructurados y coherentes.',
            'desaprobado' => 'El estudiante aún no ha alcanzado completamente los objetivos del nivel Secondary Plus
B1. Presenta dificultades para expresarse con fluidez y claridad en situaciones
complejas, comprender textos más extensos y redactar textos bien organizados. Se
recomienda reforzar la práctica oral y escrita, así como el estudio de estructuras
gramaticales avanzadas para mejorar su desempeño.',
            'level' => 8
        ]);
        Level::create([
            'name' => 'Secondary Plus B2 (B2)',
            'description' => 'En este nivel, el estudiante es capaz de comunicarse con fluidez y espontaneidad en una
amplia variedad de situaciones sociales, académicas y profesionales. Puede expresar
opiniones complejas, argumentar y debatir sobre diversos temas con claridad y
coherencia. El estudiante entiende textos extensos y complejos, tanto literarios como
técnicos, y es capaz de resumir información relevante y detalles importantes. También
puede escribir textos claros, detallados y bien estructurados, adaptados a diferentes
contextos y audiencias.
Este nivel representa una competencia intermedia alta, que prepara al estudiante para
interactuar eficazmente en entornos de habla inglesa de nivel académico y profesional.',
            'aprobado' => 'El estudiante ha alcanzado con éxito los objetivos del nivel Secondary Plus B2.
Demuestra una comunicación fluida y espontánea en inglés, capaz de expresar opiniones
complejas, participar en debates y comprender textos extensos y técnicos. Además,
escribe textos bien estructurados y adaptados a diferentes contextos.',
            'desaprobado' => 'El estudiante aún no ha alcanzado completamente los objetivos del nivel Secondary Plus
B2. Presenta dificultades para comunicarse con fluidez en temas complejos, comprender
textos técnicos y escribir textos bien estructurados. Se recomienda continuar trabajando
en la ampliación de vocabulario, estructuras gramaticales avanzadas y práctica en
comprensión y expresión oral y escrita.',
            'level' => 9
        ]);
        Level::create([
            'name' => 'Upper Secondary Plus B1',
            'description' => 'En este nivel, el estudiante puede comunicarse con confianza en situaciones cotidianas y
algunas situaciones más complejas relacionadas con la vida académica y social. Puede
expresar opiniones, describir experiencias y eventos, y participar en discusiones
sencillas. El estudiante comprende textos escritos y orales sobre temas familiares, y es
capaz de redactar textos coherentes y organizados, como cartas, correos electrónicos y
relatos breves. Este nivel refleja una competencia intermedia, donde el estudiante
empieza a utilizar el inglés de manera más autónoma y funcional en diferentes contextos.',
            'aprobado' => 'El estudiante ha cumplido satisfactoriamente los objetivos del nivel Upper Secondary
Plus B1. Demuestra confianza para comunicarse en inglés en situaciones cotidianas y
académicas, expresando opiniones, describiendo experiencias y participando en
discusiones básicas. Comprende textos y audios relacionados con temas familiares y
redacta textos claros y organizados.',
            'desaprobado' => 'El estudiante aún no ha alcanzado completamente los objetivos del nivel Upper
Secondary Plus B1. Presenta dificultades para comunicarse con confianza en situaciones
cotidianas y académicas, comprender textos y audios claros, y redactar textos
organizados. Se recomienda reforzar la práctica oral y escrita, así como el estudio de
estructuras gramaticales básicas para mejorar su desempeño.',
            'level' => 10
        ]);
        Level::create([
            'name' => 'Upper Secondary Plus B2',
            'description' => 'En este nivel, el estudiante puede comunicarse con fluidez, seguridad y espontaneidad
en inglés, incluso en contextos académicos y sociales más complejos. Comprende textos
y audios detallados sobre una amplia gama de temas, y es capaz de expresar opiniones
bien argumentadas, narrar experiencias y participar en debates. También puede redactar
textos claros, estructurados y detallados, ajustando el estilo y el registro según la
audiencia o el propósito (por ejemplo, ensayos, informes, correos formales e
informales).Este nivel indica una competencia independiente avanzada, que permite
interactuar eficazmente en entornos educativos y profesionales donde se usa el inglés.',
            'aprobado' => 'El estudiante ha alcanzado con éxito los objetivos del nivel Upper Secondary Plus B2. Se
comunica con fluidez y precisión en inglés, comprende textos complejos y participa
activamente en discusiones y presentaciones. Redacta textos bien estructurados y
adecuados a distintos contextos, mostrando un dominio avanzado del idioma.',
            'desaprobado' => 'El estudiante aún no ha alcanzado completamente los objetivos del nivel Upper
Secondary Plus B2. Presenta dificultades para comunicarse con fluidez en situaciones
complejas, interpretar textos extensos o redactar textos bien estructurados. Se
recomienda continuar reforzando la expresión oral, la comprensión lectora y la escritura
formal para lograr un mejor dominio del idioma.',
            'level' => 11
        ]);
        Level::create([
            'name' => 'First Upper (B2)',
            'description' => 'Un estudiante en el nivel First Upper B2 tiene un dominio intermedio-alto del inglés. Es
capaz de comunicarse con fluidez y espontaneidad con hablantes nativos sin causar
tensión. Puede comprender textos complejos, participar en debates, expresar ideas de
forma clara y matizada, y escribir textos detallados y coherentes sobre una variedad de
temas. Este nivel indica que el estudiante puede desenvolverse de manera autónoma en
contextos académicos, laborales y sociales.',
            'aprobado' => 'El estudiante ha alcanzado exitosamente los objetivos del nivel First Upper B2. Se
comunica con fluidez y seguridad en una variedad de contextos académicos y sociales.
Demuestra una buena comprensión de textos complejos y es capaz de redactar textos
claros, estructurados y bien argumentados. Participa activamente en discusiones,
expresando ideas de manera coherente y precisa.',
            'desaprobado' => 'El estudiante aún no ha alcanzado completamente los objetivos del nivel First Upper B2.
Presenta dificultades para comunicarse con fluidez en contextos complejos, interpretar
textos extensos o redactar escritos con claridad y coherencia. Se recomienda reforzar la
comprensión auditiva, la expresión escrita y el uso de estructuras gramaticales
avanzadas para lograr un mejor dominio del idioma.',
            'level' => 12
        ]);
        Level::create([
            'name' => 'Upper Secondary Plus C1',
            'description' => 'Un estudiante con nivel C1 posee un dominio avanzado del inglés, lo que le permite
utilizar el idioma con eficacia, flexibilidad y fluidez en contextos tanto académicos como
profesionales. Puede comprender textos complejos y extensos, tanto escritos como
orales, y expresarse con claridad, precisión y coherencia.
Este nivel permite interactuar con hablantes nativos sin dificultad, participar en debates
formales, redactar textos bien estructurados y adaptarse con facilidad a diferentes
registros del lenguaje',
            'aprobado' => 'El estudiante ha alcanzado con éxito los objetivos del nivel Upper Secondary Plus C1. Se
comunica de manera fluida, precisa y efectiva en una amplia gama de contextos formales
e informales. Demuestra un alto grado de comprensión auditiva y lectora, así como la
capacidad de expresarse con claridad y coherencia tanto de forma oral como escrita. Su
uso del idioma muestra madurez, amplitud de vocabulario y dominio de estructuras
avanzadas.',
            'desaprobado' => 'El estudiante aún no ha alcanzado completamente los objetivos del nivel Upper
Secondary Plus C1. Presenta dificultades para mantener la fluidez y precisión necesarias
en contextos complejos, y necesita seguir fortaleciendo sus habilidades en comprensión
auditiva, producción escrita y uso avanzado del vocabulario y la gramática. Se
recomienda un refuerzo continuo para alcanzar el dominio esperado en este nivel',
            'level' => 13
        ]);
        Level::create([
            'name' => 'Advanced EDAM Upper C1',
            'description' => 'El estudiante en este nivel posee un dominio avanzado y autónomo del idioma inglés,
capaz de comunicarse con fluidez, naturalidad y precisión en contextos académicos,
sociales y profesionales exigentes. Entiende y produce textos complejos, con estructuras
sofisticadas, adaptando el estilo y el registro según la situación. Este nivel indica una
competencia lingüística cercana al nivel nativo en cuanto a comprensión y expresión,
especialmente en tareas intelectualmente exigentes o especializadas.',
            'aprobado' => 'El estudiante ha alcanzado con éxito los objetivos del nivel Advanced EDAM Upper C1.
Demuestra un dominio avanzado del inglés, comunicándose con fluidez, precisión y
naturalidad en contextos académicos y profesionales complejos. Comprende y produce
textos complejos con claridad y coherencia, y adapta su lenguaje a diferentes situaciones
y audiencias con madurez y eficacia.',
            'desaprobado' => 'El estudiante aún no ha alcanzado completamente los objetivos del nivel Advanced EDAM
Upper C1. Presenta dificultades para mantener la fluidez y precisión necesarias en
contextos académicos y profesionales exigentes. Se recomienda fortalecer sus
habilidades en comprensión auditiva, expresión escrita y el uso de estructuras
lingüísticas avanzadas para lograr un dominio más completo del idioma.',
            'level' => 14
        ]);

        Level::create([
            'name' => 'Proficiency Upper C2',
            'description' => 'El estudiante con nivel Proficiency Upper C2 posee un dominio excepcional del inglés,
equivalente al de un hablante nativo culto y bien educado. Puede comprender con
facilidad prácticamente todo lo que lee y escucha, resumir información de diferentes
fuentes orales y escritas, y expresarse espontáneamente con fluidez, precisión y
coherencia absoluta. Este nivel implica que el estudiante puede manejar cualquier tipo
de comunicación, incluso en situaciones altamente especializadas, complejas o
técnicas, con una gran eficacia y naturalidad.',
            'aprobado' => 'El estudiante ha alcanzado un dominio excepcional del inglés, cumpliendo con los
objetivos del nivel Proficiency Upper C2. Se comunica con fluidez, precisión y naturalidad
en cualquier contexto, comprendiendo y produciendo textos complejos y especializados
con un alto nivel de sofisticación. Su manejo del idioma es equiparable al de un hablante
nativo culto y está preparado para desempeñarse con éxito en ambientes académicos y
profesionales exigentes.',
            'desaprobado' => 'El estudiante aún no ha alcanzado el dominio excepcional requerido para el nivel
Proficiency Upper C2. Presenta dificultades para comunicarse con fluidez y precisión en
contextos altamente especializados y complejos. Se recomienda continuar fortaleciendo
sus habilidades en comprensión, expresión oral y escrita para lograr un manejo completo
y sofisticado del idioma.',
            'level' => 15
        ]);
    }
}
