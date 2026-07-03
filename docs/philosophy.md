# Modulo Cms - Filosofia, Religione, Politica, Zen

## 🎯 Panoramica

Il modulo Cms è il sistema di gestione dei contenuti per l'architettura Laraxot, responsabile della gestione di pagine, menu, sezioni e blocchi di contenuto. La sua filosofia è incentrata sulla **flessibilità, la modularità e la type safety**, garantendo che i contenuti siano facilmente gestibili, traducibili e renderizzabili in modo coerente.

## 🏛️ Filosofia: Contenuto Strutturato e Modulare

### Principio: Il Contenuto è un Sistema di Blocchi Compositi

La filosofia di Cms si basa sull'idea che il contenuto web debba essere strutturato in blocchi modulari e componibili, piuttosto che in pagine monolitiche. Questo approccio permette la massima flessibilità nella creazione e gestione dei contenuti, facilitando la riusabilità e la manutenzione.

- **Blocchi Compositi**: Ogni contenuto è composto da blocchi (`BlockData`) che possono essere combinati in modo flessibile.
- **Separazione Contenuto/Presentazione**: Il contenuto è separato dalla sua presentazione, permettendo cambiamenti di design senza modificare i dati.
- **Multi-Localizzazione**: Supporto nativo per contenuti multi-lingua attraverso `BaseModelLang` e il trait `HasTranslations`.
- **Sushi Models**: Utilizzo di modelli Sushi (`SushiToJsons`) per configurazioni leggere e performanti.

## 📜 Religione: La Sacra Gerarchia dei Contenuti

### Principio: Ogni Contenuto ha il Suo Posto nella Gerarchia

La "religione" di Cms si manifesta nella rigorosa aderenza a una gerarchia ben definita dei contenuti, dove ogni elemento ha un ruolo preciso e relazioni chiare con gli altri.

- **Gerarchia Pagine**: `Page` è l'entità principale, contenente `content_blocks`, `sidebar_blocks` e `footer_blocks`.
- **Menu Gerarchici**: `Menu` utilizza `HasRecursiveRelationshipsContract` e `TypedHasRecursiveRelationships` per gestire strutture ad albero complesse.
- **Sezioni e Blocchi**: `Section` contiene `blocks`, che a loro volta sono composti da `BlockData`.
- **BaseTreeModel**: Modello astratto per entità gerarchiche, garantendo coerenza nell'implementazione delle relazioni ricorsive.

### Esempio: Struttura Gerarchica di `Menu`

```php
// Modules/Cms/app/Models/Menu.php
namespace Modules\Cms\Models;

use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Modules\Xot\Models\Traits\TypedHasRecursiveRelationships;

class Menu extends BaseModel implements HasRecursiveRelationshipsContract
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    
    // Menu può avere parent e children, formando una struttura ad albero
    // Utilizza i metodi del contratto: parent(), children(), ancestors(), descendants()
}
```
Questa implementazione garantisce che i menu seguano una struttura gerarchica rigorosa e type-safe, un pilastro della "religione" di Cms.

## ⚖️ Politica: Type Safety e Compilazione Sicura (PHPStan Livello 10)

### Principio: Ogni Blocco è Type-Safe, Ogni View è Verificata

La "politica" di Cms è l'applicazione rigorosa della type safety, specialmente nella gestione dei blocchi di contenuto e nella compilazione delle view. Ogni blocco deve essere validato e ogni view deve esistere prima del rendering.

- **PHPStan Livello 10**: Tutti i componenti del modulo Cms devono passare l'analisi statica al livello massimo.
- **`BlockData` Type Safety**: La classe `BlockData` garantisce che ogni blocco abbia un `type`, `data` e `view` validi, verificando l'esistenza della view prima dell'istanziazione.
- **`HasBlocks` Trait**: Il trait `HasBlocks` gestisce la compilazione sicura dei blocchi, supportando Blade rendering e traduzioni.
- **`SushiToJsons`**: I modelli Sushi garantiscono che i dati JSON siano sempre validi e type-safe.

### Esempio: `BlockData` e Validazione View

```php
// Modules/Cms/app/Datas/BlockData.php
namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

class BlockData extends Data implements Wireable
{
    public string $type;
    public array $data;
    public string $view;

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
        Assert::string($view = Arr::get($data, 'view', 'ui::empty'));
        if (! view()->exists($view)) {
            throw new Exception('view not found: '.$view);
        }
        $this->view = $view;
    }
}
```
Questo approccio garantisce che ogni blocco sia sempre valido e che la sua view esista prima del rendering, un aspetto cruciale della "politica" di Cms.

## 🧘 Zen: Semplicità e Auto-Scoperta

### Principio: Il Contenuto si Auto-Organizza

Lo "zen" di Cms si manifesta nella preferenza per l'auto-scoperta e le convenzioni rispetto alla configurazione esplicita. Il modulo mira a rendere la gestione dei contenuti il più intuitiva possibile.

- **Auto-Scoping per Slug**: Le pagine e le sezioni sono identificate automaticamente tramite `slug`, eliminando la necessità di configurazioni complesse.
- **Blade Compilation Automatica**: Il trait `HasBlocks` compila automaticamente le espressioni Blade nei blocchi, senza intervento manuale.
- **Traduzione Automatica**: I modelli `BaseModelLang` gestiscono automaticamente le traduzioni, utilizzando la lingua primaria come fallback.
- **View Components**: I componenti Blade (`Page`, `PageContent`) gestiscono automaticamente il rendering dei blocchi, senza configurazione esplicita.

### Esempio: `PageContent` Component

```php
// Modules/Cms/app/View/Components/PageContent.php
namespace Modules\Cms\View\Components;

use Modules\Cms\Models\Page as PageModel;
use Modules\Cms\Datas\BlockData;

class PageContent extends Component
{
    public function __construct(string $slug)
    {
        $page = PageModel::firstOrCreate(
            ['slug' => $slug],
            ['title' => $slug, 'content_blocks' => []]
        );
        $blocks = $page->content_blocks;
        if (! is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            $blocks = $page->getTranslation('content_blocks', $primary_lang);
        }
        $this->blocks = BlockData::collect($blocks);
    }
}
```
Questo componente incarna lo zen dell'auto-scoperta, creando automaticamente la pagina se non esiste e gestendo le traduzioni senza configurazione esplicita.

## 📚 Riferimenti Interni

- [Documentazione Master del Progetto](../../../../docs/project-master-analysis.md)
- [Filosofia Completa Laraxot](../../xot/docs/philosophy-complete.md)
- [Regole Critiche di Architettura](../../xot/docs/critical-architecture-rules.md)
- [Relazioni Ricorsive (Contratto)](../../xot/docs/recursive-relationships-contract.md)
- [Documentazione Cms Blocks System](./content-blocks-system.md)
- [Documentazione Cms Architecture](./architecture/)

# Cms Module: Philosophy, Purpose, and Design Principles

**Date:** December 23, 2025

## 🎯 Purpose and Core Responsibilities

The `Cms` module (Content Management System) in this context is not a traditional system for creating pages and posts directly, but rather a powerful **frontend and theme management layer**. Its core purpose is to provide dynamic control over the application's presentation and user experience. Key responsibilities include:

1.  **Dynamic Theme Management:** Enabling the application to dynamically load and switch between different frontend themes, controlled via configurations (`XotData::pub_theme`). This allows for complete customization of the application's visual identity.
2.  **View Path Resolution:** Manipulating Laravel's view paths (`config('view.paths')`) to prioritize views from the active theme. This ensures that theme-specific Blade templates and components are rendered over default ones.
3.  **Livewire Integration:** Configuring Livewire's view and class namespaces to correctly resolve theme-specific Livewire components, allowing themes to extend or override dynamic functionalities.
4.  **Blade Component Registration:** Registering Blade anonymous components provided by the active theme, facilitating a modular approach to UI development where themes can introduce their own reusable components.
5.  **Theme-Specific Translation Loading:** Loading language files from the active theme's `lang` directory, ensuring that the frontend content is localized according to the theme's specifications.
6.  **Robust Path Handling:** Utilizing `Modules\Xot\Actions\File\FixPathAction` to ensure that all theme-related file paths are correctly resolved across different environments, enhancing reliability.

## 💡 Philosophy & Zen (Guiding Principles)

The `Cms` module embodies a set of principles focused on flexibility, consistency, and a clear separation of concerns in the presentation layer:

*   **Frontend Presentation Agnosticism:** The fundamental "politics" of this module is the decoupling of backend business logic from frontend presentation. It champions the idea that the application's functionality should remain robust and independent, regardless of its visual appearance. This allows the application's "look and feel" to be highly dynamic and swappable.
*   **Configuration-Driven Customization:** All aspects of theme selection and loading are driven by configuration (primarily through `XotData`). This ensures that themes are not hardcoded but are easily managed and changed, promoting flexibility and reducing deployment complexity.
*   **Consistency Through Centralized Theming:** By enforcing a single, active public theme, the `Cms` module ensures a consistent visual language and user experience across the entire application. This centralized control prevents UI fragmentation and maintains brand integrity.
*   **Deep Integration with Laravel/Livewire:** The module demonstrates a commitment to leveraging the power of the Laravel ecosystem, integrating deeply with Blade, Livewire, and the view system to provide a rich and dynamic frontend.
*   **Architectural Adherence (via `Xot`):** By extending `XotBaseServiceProvider` and depending on `XotData`, the `Cms` module rigorously adheres to the overarching `Xot` architectural patterns. This ensures modularity, maintainability, and predictable behavior within the project's ecosystem.
*   **"Religion" (The Dynamic Frontend Imperative):** The "religion" of the `Cms` module is a steadfast belief in the necessity and power of a dynamic frontend. It dictates that the presentation layer should not be a static artifact but a living, modular component capable of rapid evolution and adaptation to user needs, marketing trends, or brand changes without disrupting core logic.
*   **"Zen" (Effortless Presentation Layer Harmony):** The "zen" of the `Cms` module is to achieve a state of effortless harmony between the application's robust backend and its flexible frontend. It aims to simplify the creation, management, and deployment of diverse visual experiences, allowing developers and designers to achieve elegant and effective presentation with minimal friction, fostering a sense of calm and control over the application's appearance.

## 🤝 Business Logic (Presentation-Focused Support)

The `Cms` module's business logic is entirely focused on supporting and managing the **presentation layer** of the application. It is crucial for:

*   **Brand Identity and User Experience:** Directly enabling consistent branding, visual identity, and a coherent user experience across the application. This is vital for customer recognition and satisfaction.
*   **Marketing Agility:** Facilitating rapid changes for marketing campaigns, seasonal updates, or A/B testing of different UIs, directly impacting user engagement and conversion rates.
*   **Multi-Client/Tenant Branding:** (In a multi-tenant context, if applicable) allowing individual clients or tenants to customize their application's appearance, reinforcing their unique brand identity.
*   **Content Delivery Framework:** Providing the dynamic framework through which any application content (whether static or dynamically generated by other modules) is ultimately rendered and delivered to the end-user in a visually appealing and structured manner.

In essence, the `Cms` module ensures that the application always "looks the part," providing the dynamic canvas upon which all other business functionalities are displayed.

## 🤖 Integration with Model Context Protocol (MCP)

The `Cms` module, as the dynamic frontend and theme management layer, can significantly benefit from integration with Model Context Protocol (MCP) servers. MCPs provide enhanced capabilities for inspecting, managing, and debugging the application's presentation layer, aligning perfectly with `Cms`'s philosophy of frontend agnosticism and effortless customization.

### Alignment with `Cms`'s Philosophy:

*   **Frontend Presentation Agnosticism:** MCPs provide tools to inspect and validate the active theme's views, assets, and configurations, ensuring that the decoupling between backend and frontend is maintained and correctly applied. Filesystem MCP is particularly valuable here.
*   **Configuration-Driven Customization:** MCPs can help manage and verify theme-specific configurations. Laravel Boost could inspect the `view.paths` configuration at runtime to confirm the active theme's resolution.
*   **Consistency Through Centralized Theming:** MCPs offer capabilities to analyze theme files and structures, helping to enforce consistency and identify deviations from design standards across themes.
*   **Developer Experience (DX) Enhancement:** For designers and developers working on themes, quickly inspecting loaded views, CSS, and JS paths via Filesystem MCP, or debugging Livewire components via Laravel Boost, greatly simplifies the workflow.
*   **"Zen" (Effortless Presentation Layer Harmony):** MCPs contribute to this zen by providing intelligent access to the dynamic frontend context, making it easier to manage, debug, and ensure the harmony between backend and frontend.

### Key MCPs for `Cms`'s Operations:

1.  **Laravel Boost (MCP)**: Essential for inspecting runtime view paths, loaded Blade components, and Livewire component configurations, particularly useful when debugging theme-specific rendering issues.
2.  **Filesystem (MCP)**: Crucial for navigating theme directories, inspecting Blade files, CSS, JavaScript, and translation files within the active theme, validating asset paths and ensuring correct loading.
3.  **Memory (MCP)**: Can store and retrieve best practices for theme development, common theming issues, and architectural decisions related to frontend customization, enhancing knowledge transfer.
4.  **Git (MCP)**: Aids in reviewing changes to theme files, configurations, or Blade components, ensuring version control and consistency in frontend development.
5.  **Playwright/Puppeteer (MCP)**: Invaluable for UI testing of themes, generating screenshots, and verifying visual consistency across different browsers, directly supporting the quality of the frontend presentation.

By leveraging these MCPs, the `Cms` module can ensure its complex frontend management logic is robust, verifiable, and deeply integrated into the development and operational workflows, fostering truly effortless frontend customization.