# Notion2Web

N2Web turns your Notion HTML export into a fully functional static website.

## What is Notion?
Notion is an online tool. But I can't tell you what it really is. It combines a content-management-system, a project-management-tool in a single no-code application builder. It is extremely versatile and in the end, it's what you make with it.

## What is Notion2Web?
N2Web (this program here) takes the Notion HTML export and turns it into an own website. The HTML export is really well done, but it lacks on some features (more about below).

Also N2Web gives developers the ability to 

### Why souldn't I use the inbuild "share to web function" in Notion?
First of all: you can! The share-to-web function in Notion is great. But it also has some problems, which N2Web tries to solve:

- **Data privacy issues/GDPR:** Notion is a company, based in the US. Companies from the EU are not allowes to use US services right away. In fact, if a company wants to use Notion in a 100% legally secure way, they will have hard time to achieve that (cookie consent, privacy information). _**→ N2Web solves this because you'll host the application yourself. Also vanilla N2Web doesn't create a cookie and don't include external ressources like fonts or something.**_
- **Styling:** If you use a shared page from Notion, you have to stick with their design. While Notion it self looks reasonable, it wont fit into you companies or personal corporate identity necessarily. _**→ N2Web it 100% themeable. You can change nearly everything with little knowledge of CSS and HTML.**_
- **Versionizing:** Sometimes you may don't want to share every single change to the weg directly. Notion publishs changes instantly. While this is most of the time a nice feature, sometimes you simply want to decide yourself when you publish something. _**→ With N2Web you decide when you update the app content.**_
- **Navigation & Logos:** You wont be able to add more Links, a Logo and Buttons to the top-level Navigation of Notion. _**→ With N2Web you can set up a main Navigation and add a logo.**_

### Why shouldn't I simply use the raw HTML-Export of Notion?
The HTML export is really well made, but it lacks on some features:

- No Navigation
  - No back button
  - no breadcrumbs
- no search function
- no simple way to change the look-and-feel

## How do I use Notion2Web?

- Download the latest release.
- Unzip the Archive
- Go to your Notion page which you want to publish
- Klick on "..."-Button in the top right corner
- Select "Export"
- Select "HTML" and "include subpages"
- Unzip the downloaded Archive
- Copy *the contents* of the unzipped Notion export into the "Contents" folder of the Notion2Web folder
- Upload the whole Notion2Web folder to your Webserver (PHP has to be enabled on you server)
- → thats it, the Notion export is now available on you website (when its root directory is pointing into uploaded folder)

## Dokumentation & Demo
I've set up a more complete documentation as demo here:
→ LINK

## Customization
Fell free to customize it. You'll find sophisticated informations in documentation.
