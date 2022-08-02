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

  new(category: any) {
    return this.http.post(`${this.api}/categories`, category);
  }

  update(category: any) {
    return this.http.put(`${this.api}/categories/${category.slug}`, category);
  }

  getForAdmin(slug: string) {
    return this.http.get(`${this.api}/admin/categories/${slug}`);
  }

  delete(slug: string) {
    return this.http.delete(`${this.api}/categories/${slug}`);
  }
}
