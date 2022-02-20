# Notion2Web

N2Web turns your Notion HTML export into a fully functional static website.

![Artboard](https://user-images.githubusercontent.com/9517567/154849583-5907457e-f49f-43bc-b4ba-981a5eab9719.png)


## What is Notion?
Notion is an online tool. But I can't tell you what it really is. It combines a content-management-system, a project-management-tool in a single no-code application builder. It is extremely versatile and in the end, it's what you make with it.

## What is Notion2Web?
N2Web (this program here) takes the Notion HTML export and turns it into an own website. The HTML export is really well done, but it lacks on some features (more about below).

Also N2Web gives developers the ability to 

### Why shouldn't I use the inbuilt "share to web function" in Notion?
First of all: you can! The share-to-web function in Notion is great. But it also has some problems, which N2Web tries to solve:

- **Data privacy issues/GDPR:** Notion is a company, based in the US. Companies from the EU are not allowes to use US services right away. In fact, if a company wants to use Notion in a 100% legally secure way, they will have hard time to achieve that (cookie consent, privacy information). 
  - **→ N2Web solves this because you'll host the application yourself. Also vanilla N2Web doesn't create a cookie and don't include external ressources like fonts or something.**
- **Styling:** If you use a shared page from Notion, you have to stick with their design. While Notion it self looks reasonable, it wont fit into you companies or personal corporate identity necessarily. 
  - **→ N2Web is 100% themeable. You can change nearly everything with little knowledge of CSS and HTML.**
- **Versionizing:** Sometimes you may don't want to share every single change to the weg directly. Notion publishs changes instantly. While this is most of the time a nice feature, sometimes you simply want to decide yourself when you publish something. 
  - **→ With N2Web you decide when you update the app content.**
- **Navigation & Logos:** You wont be able to add more Links, a Logo and Buttons to the top-level Navigation of Notion. 
  - **→ With N2Web you can set up a main Navigation and add a logo.**

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
https://notion2web.lehmann.wtf/

## Customization
Feel free to customize it. You'll find sophisticated informations in documentation.


# the compact feature list of N2Web
- Set up in minutes - no programming knowledge required. Simple drag and drop files into the "contents" folder and you're good to go.
- Super fast
- Editable menus
- Self hosting gives you control
- technically GDPR compliant right away (if you host in Europe)
- Themable - 4 themes aleady installed
- Hackable - easy code, simple structure
- Inbuilt search, which shows the relevance of a search result and calculates the importancy of the search term to page.


