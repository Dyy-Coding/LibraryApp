import { defineStore } from "pinia";
import axios from "axios";

// ✅ Base API URL
const BASE_URL = "http://127.0.0.1:8000/api/books";

// ✅ Define Pinia store
export const useBooksStore = defineStore("books", {
  state: () => ({
    books: [],        // Store all books
    loading: false,   // Track loading state
    error: null       // Store any API errors
  }),

  actions: {
    // 📥 Fetch all books from API
    async fetchBooks() {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.get(BASE_URL);
        this.books = response.data;
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to fetch books.";
      } finally {
        this.loading = false;
      }
    },

    // 📄 Get a single book by ID
    async getBook(id) {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.get(`${BASE_URL}/${id}`);
        return response.data;
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to get book.";
        return null;
      } finally {
        this.loading = false;
      }
    },

    // ➕ Create a new book
    async addBook(bookData) {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.post(BASE_URL, bookData);
        this.books.push(response.data);
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to add book.";
      } finally {
        this.loading = false;
      }
    },

    // ✏️ Update an existing book by ID
    async updateBook(id, updatedData) {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.put(`${BASE_URL}/${id}`, updatedData);
        const index = this.books.findIndex((book) => book.id === id);
        if (index !== -1) this.books[index] = response.data;
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to update book.";
      } finally {
        this.loading = false;
      }
    },

    // ❌ Delete a book by ID
    async deleteBook(id) {
      this.loading = true;
      this.error = null;
      try {
        await axios.delete(`${BASE_URL}/${id}`);
        this.books = this.books.filter((book) => book.id !== id);
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to delete book.";
      } finally {
        this.loading = false;
      }
    }
  }
});
