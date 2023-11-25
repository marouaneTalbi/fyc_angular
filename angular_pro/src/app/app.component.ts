import { AfterViewInit, Component, ElementRef, HostListener, ViewChild } from '@angular/core';
import {ArticleService } from './article/article.service';
import { EMPTY, Observable, catchError, combineLatest, concat, forkJoin, fromEvent, map, merge, of, switchMap, tap} from 'rxjs'
import { NgForm }from '@angular/forms';

@Component({
selector: 'app-root',
templateUrl: './app.component.html',
styleUrls: ['./app.component.scss']
})

export class AppComponent implements AfterViewInit{
  articles: any = [];
  articlesWithStats:any = [];
  myField: any = ""; 

  @ViewChild ('myForm', { read: ElementRef }) formElementRef?: ElementRef;

  constructor (private articleService: ArticleService) {}


  authorOfTheWeekArticles(): Observable<any> {
    return forkJoin(
     [this.articleService.getArticles (),
      this.articleService.getAuthors()]
    ).pipe (
      map(( [currentArticles, authors]) => {
        let authorOfTheWeek = authors [5]; // l'autheur de la semaine author4
        return currentArticles.filter((article:any) => article['author'] == authorOfTheWeek.name)
      }),
        catchError(error => {
          console.error('Erreur rencontrée :', error);
          return of([]); 
        })
    )
  }
  ngAfterViewInit() {
    this.authorOfTheWeekArticles ().subscribe((result:any) => console.log(result))
  }

  // 2REQUETES---------------------------------
  // authorOfTheWeekArticles(): Observable<any> {
  //   return forkJoin(
  //     this.articleService.getArticles (),
  //     this.articleService.getAuthors()
  //   ).pipe (
  //     map(( [currentArticles, authors]) => {
  //       let authorOfTheWeek = authors [5]; // l'autheur de la semaine author4
  //       return currentArticles.filter((article:any) => article['author'] == authorOfTheWeek.name)
  //     }),
  //       catchError(error => {
  //         console.error('Erreur rencontrée :', error);
  //         return of([]); 
  //       })
  //   )
  // }
  // ngAfterViewInit() {
  //   this.authorOfTheWeekArticles ().subscribe((result:any) => console.log(result))
  // }


  // REQUETE + EVENT ________________________________________
  // searchArticle(): Observable<any> {
  //   const formEvent$ = fromEvent(this.formElementRef?.nativeElement, 'submit');
  //   return formEvent$.pipe(
  //     map(() => this.myField),
  //     switchMap(query => this.articleService.searchArticles(query)),
  //     catchError(error => {
  //       console.error('Erreur lors de la recherche des articles :', error);
  //       return of([]); 
  //     })
  //   );
  // }

  // ngAfterViewInit() {
  //   if (this. formElementRef && this.formElementRef.nativeElement) {
  //     this.searchArticle().subscribe((result) => console.log(result))
  //   }
  // }

// 2 requete 2 _________________________________
  // getStatistics(): Observable<any> {
  //   return this.articleService.getArticles().pipe(
  //     switchMap(articles => {
  //       if (articles.length === 0) {
  //         return of([]);
  //       }
  //       return forkJoin(
  //         articles.map((article:any) =>
  //           this.articleService.getArticleStats(article.id).pipe(
  //             map(stats => ({ ...article, stats }))
  //           )
  //         )
  //       );
  //     }),
  //     catchError(error => {
  //       console.error('Erreur lors de la récupération des statistiques des articles :', error);
  //       return of([]); 
  //     })
  //   );
  // }
  
  // ngAfterViewInit() {
  //   this.getStatistics().subscribe(articlesWithStats => {
  //     console.log('Articles avec statistiques chargés', articlesWithStats);
  //   });
  // }


  //    3  observables ______________________________
  // getArticleAndStats(): Observable<any> {
  //   return fromEvent(this.formElementRef?.nativeElement, 'submit').pipe(
  //     tap((event: any) => event.preventDefault()),
  //     map(() => this.myField),
  //     switchMap(query => this.articleService.searchArticles(query).pipe(
  //       catchError(error => {
  //         console.error('Erreur lors de la recherche des articles:', error);
  //         return of([]); 
  //       })
  //     )),
  //     switchMap(articles => {
  //       if (articles.length === 0) {
  //         return of([]);
  //       }
  //       return forkJoin(
  //         articles.map((article: any) =>
  //           this.articleService.getArticleStats(article.id).pipe(
  //             map(stats => ({ ...article, stats })),
  //             catchError(error => {
  //               console.error('Erreur lors de la récupération des statistiques:', error);
  //               return of({ ...article, stats: {} }); 
  //             })
  //           )
  //         )
  //       );
  //     }),
  //     catchError(error => {
  //       console.error('Erreur globale dans getArticleAndStats:', error);
  //       return of([]); 
  //     })
  //   );
  // }

  // ngAfterViewInit() {
  //   if (this.formElementRef && this. formElementRef.nativeElement) {
  //   this.getArticleAndStats ().subscribe (articlesWithStats => {
  //     console.log('Articles avec leurs statistiques:', articlesWithStats);
  //   });
  //   }
  // }

// MERGE ------------------------------------------

  // @ViewChild('button1') button1?: ElementRef;
  // @ViewChild('button2') button2?: ElementRef;

  // ngAfterViewInit() {
  //  const button1Click$ = fromEvent(this.button1?.nativeElement, 'click').pipe(
  //     map(event => ({ event, button: 'button1' }))
  //   );
  //   const button2Click$ = fromEvent(this.button2?.nativeElement, 'click').pipe(
  //     map(event => ({ event, button: 'button2' }))
  //   );
  
  //   const combinedButton$ = merge(button1Click$, button2Click$);
  //   combinedButton$.subscribe(data => {
  //     console.log('le boutton qui a été cliqué est ==> ', data.button);
  //   });
  // }

  // Concat ____________________________________
  // ngAfterViewInit() {
  //   const articles$ = this.articleService.getArticles().pipe(
  //     map(response => ({response, dataOf: 'Les Articles'}))
  //   );
  //   const authors$ = this.articleService.getAuthors().pipe(
  //     map(response => ({response, dataOf: 'Les Auteurs'}))
  //   );

  //   const concatenated$ = concat(articles$, authors$);
  //   concatenated$.subscribe(data => {
  //     console.log(`${data.dataOf} ==> `,data.response); 
  //   });
  // }

  //CombienLatest _________________________________

  // @ViewChild('button1') button1?: ElementRef;
  // ngAfterViewInit() {
  //   const articles$ = this.articleService.getArticles().pipe(
  //     map(response => ({response, dataOf: 'Les Articles'}))
  //   );
  //   const button1Click$ = fromEvent(this.button1?.nativeElement, 'click').pipe(
  //     map(event => ({ event, dataOf: 'button1' }))
  //   );

  //   const combined$ = combineLatest([articles$, button1Click$]);
  //   combined$.subscribe(([articlesData, buttonClickData]) => {
  //     console.log('Données combinées:', articlesData, buttonClickData);
  //   });
  // }

}