import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class CategoryService {
  private api = environment.apiUrl;

  constructor(private http: HttpClient) {}

  all() {
    return this.http.get(`${this.api}/categories`);
  }

  get(slug: string) {
    return this.http.get(`${this.api}/categories/${slug}`);
  }
}
