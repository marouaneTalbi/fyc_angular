import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ArticleService {
  private apiUrl = 'http://localhost:8001'; // URL de l'API Symfony

  constructor(private http: HttpClient) { }

  getArticles(): Observable<any> {
    return this.http.get(`${this.apiUrl}/article`);
  }

  getArticle($id:any): Observable<any> {
    return this.http.get(`${this.apiUrl}/article/${$id}`);
  }

  searchArticles(query: string): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/article/search?search=${query}`);
  }

  getArticleStats(articleId: number): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/article/${articleId}/stats`);
  }

  getComments(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/article/comments`);
  }

  getAuthors(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/article/authors`);
  }

}
